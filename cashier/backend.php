<?php
class Cashiering
{
  // code goes here...

  protected $con;
  public function setDb($db)
  {
    $this->con = $db;
  }

  public function GetAll()
  {
    // $sql = "SELECT * FROM `payments`;";
    $sql = "SELECT *,IF(p.`paid_item_type` = 'room',IF((SELECT user_id FROM `room_bookings` WHERE id = p.`item_id`)=0, p.`booker_name`,
    (SELECT CONCAT_WS(' ',u.`first_name`,u.`last_name`) FROM `room_bookings` rb
    JOIN `users` u ON u.`id` = rb.`user_id` WHERE rb.`id` =  p.`item_id`)),p.`booker_name`) AS `booker` FROM `payments` p;";
    $result = mysqli_query($this->con, $sql);

    return $result;
  }

  public function GetAllFoodOrders()
  {
    $sql = "SELECT * FROM `food_bulk_orders` WHERE total_amount != 0;";
    $result = mysqli_query($this->con, $sql);

    return $result;
  }

  public function FoodAddOrder($customerName)
  {
    $sql = "INSERT INTO `food_bulk_orders` (`customer_name`) VALUES ('{$customerName}');";
    if ($this->con->query($sql) === TRUE) {
      $getsql = "SELECT id FROM `food_bulk_orders` ORDER BY id DESC LIMIT 1;";
      $result = mysqli_query($this->con, $getsql);
      $row = mysqli_fetch_assoc($result);
      $_SESSION['foodarr'] = array();
      $_SESSION['bulkid'] = $row['id'];
      echo "<script>
        alert('Adding of Food Order Successful');
        window.location.href='addfood.php';
      </script>";
    }
  }

  public function FinalizeFoodOrder($bulk_id)
  {
    $i = 0;
    $len = count($_SESSION['foodarr']);
    foreach ($_SESSION['foodarr'] as $food) {
      $sql = "SELECT * FROM `foods` WHERE `id` = " . $food . ";";
      $result = mysqli_query($this->con, $sql);

      $row = mysqli_fetch_assoc($result);

      $food_order = "INSERT INTO `food_orders` (`food_id`,`quantity`,`cost`,`created_at`,`food_bulk_id`)
                  VALUES ({$food},1,{$row['price']},NOW(),{$_SESSION['bulkid']});";
      $update_food_bulk = "UPDATE `food_bulk_orders` SET `total_amount` = total_amount+{$row['price']} WHERE id = {$_SESSION['bulkid']};";
      if ($this->con->query($food_order) === TRUE) {
        if ($this->con->query($update_food_bulk) === FALSE) {
          echo "<script>
          alert('Error Updating Food.');
          window.location.href='addfood.php';
          </script>";
        }
      } else {
        echo "<script>
          alert('Error Adding Food Order.');
          window.location.href='addfood.php';
          </script>";
      }
    }

    $sql = "SELECT SUM(fo.`cost`) AS `total` FROM `food_orders` fo 
    JOIN `foods` f ON f.`id` = fo.`food_id`
    WHERE fo.`food_bulk_id` = {$bulk_id};";
    $result = mysqli_query($this->con, $sql);
    $row = mysqli_fetch_assoc($result);

    $sql2 = "SELECT * FROM `food_bulk_orders` WHERE id = {$bulk_id};";
    $result2 = mysqli_query($this->con, $sql2);
    $row2 = mysqli_fetch_assoc($result2);

    $sqlupdatebulk = "UPDATE `food_bulk_orders` fbo SET fbo.`total_amount` = {$row['total']} WHERE fbo.`id` = {$bulk_id};";
    $addsql = "INSERT INTO `payments` (`item_id`,`booker_name`,`item_name`,`amount`,`payment_type`,`paid_item_type`)
    VALUES ({$bulk_id}, '{$row2['customer_name']}','Food Order', {$row2['total_amount']}, 1, 'food');";

    if ($this->con->query($sqlupdatebulk) === TRUE) {
      if ($this->con->query($addsql) === TRUE) {
        $_SESSION['bulkid'] = "";
        echo "<script>
        alert('Finalizing order Successful');
        window.location.href='food.php';
      </script>";
      } else {
        echo "<script>
        alert('Error updating order');
        window.location.href='addfood.php';
      </script>";
      }
    } else {
      echo "<script>
        alert('Error finalizing order');
        window.location.href='addfood.php';
      </script>";
    }
  }

  public function GetAllFoodPayments($bulk_id)
  {
    //$sql = "SELECT * FROM `payments` WHERE `paid_item_type` = 'food';";
    $sql = "SELECT * FROM `food_orders` fo 
    JOIN `foods` f ON f.`id` = fo.`food_id`
    WHERE fo.`food_bulk_id` = {$bulk_id};";
    $result = mysqli_query($this->con, $sql);

    return $result;
  }

  public function GetAllFoodItems()
  {
    $sql = "SELECT * FROM `foods`;";
    $result = mysqli_query($this->con, $sql);

    return $result;
  }

  public function GetAllEvents()
  {
    $sql = "SELECT e.*, (SELECT IF (COUNT(p.transdate) > 0,p.transdate,'Not Paid') FROM `payments` p WHERE p.`paid_item_type` = 'event' AND p.`item_id` = e.id) AS paid_on FROM `events` e WHERE `status` = 0;";
    $result = mysqli_query($this->con, $sql);

    return $result;
  }

  public function SaveEvents($bookername, $eventname, $eventvenue, $description, $capacity, $date, $price)
  {
    $add_event = "INSERT INTO `events` (`booker_name`,`name`,`venue`,`description`,`date`,`price`,`capacity`,`status`)
                VALUES ('{$bookername}','{$eventname}','{$eventvenue}','{$description}','{$date}',{$price},{$capacity},0);";
    if ($this->con->query($add_event) === TRUE) {
      echo "<script>
      alert('Adding of Events Successful');
      window.location.href='events.php';
    </script>";
    } else {
      echo "<script>
      alert('Error Adding Events.');
      window.location.href='events.php';
    </script>";
    }
  }

  public function SetPaidEvents($id, $payment)
  {
    $sql = "SELECT * FROM `events` WHERE `id` = " . $id . ";";
    $result = mysqli_query($this->con, $sql);

    $row = mysqli_fetch_assoc($result);
    if ($row['price'] > $payment) {
      echo "<script>
      alert('Payment Should be larger than price.');
      window.location.href='events.php';
      </script>";
    } else {
      $addsql = "INSERT INTO `payments` (`item_id`,`booker_name`,`item_name`,`amount`,`payment_type`,`paid_item_type`)
              VALUES ({$id},'{$row['booker_name']}','{$row['name']}', {$row['price']}, 1, 'event');";
      if ($this->con->query($addsql) === TRUE) {
        echo "<script>
      alert('Payment Done');
      window.location.href='events.php';
    </script>";
      } else {
        echo "<script>
      alert('Error Updating Payment Status');
      window.location.href='events.php';
    </script>";
      }
    }
  }

  public function SaveFoodPayment($id)
  {
    $sql = "SELECT * FROM `foods` WHERE `id` = " . $id . ";";
    $result = mysqli_query($this->con, $sql);

    $row = mysqli_fetch_assoc($result);
    // if ($row['price'] > $payment) {
    //   echo "<script>
    //   alert('Payment Should be larger than price.');
    //   window.location.href='addfood.php';
    //   </script>";
    // } else {

    $food_order = "INSERT INTO `food_orders` (`food_id`,`quantity`,`cost`,`created_at`,`food_bulk_id`)
                VALUES ({$id},1,{$row['price']},NOW(),{$_SESSION['bulkid']});";
    $update_food_bulk = "UPDATE `food_bulk_orders` SET `total_amount` = total_amount+{$row['price']} WHERE id = {$_SESSION['bulkid']};";
    if ($this->con->query($food_order) === TRUE) {
      if ($this->con->query($update_food_bulk) === TRUE) {
        echo "<script>
        alert('Order Added');
        window.location.href='foodbulk.php';
        </script>";
      } else {
        echo "<script>
        alert('Error Updating Food.');
        window.location.href='addfood.php';
        </script>";
      }
    } else {
      echo "<script>
        alert('Error Adding Food Order.');
        window.location.href='addfood.php';
        </script>";
    }
    // }
  }

  public function GetAllRoomPayments()
  {
    $sql = "SELECT * FROM `payments` WHERE `paid_item_type` = 'room';";
    $result = mysqli_query($this->con, $sql);

    return $result;
  }

  public function GetAllRoomTypes()
  {
    $sql = "SELECT * FROM `room_types` rt;";
    $result = mysqli_query($this->con, $sql);

    return $result;
  }

  public function GetAllRoomNumber($roomtypeid)
  {
    $sql = "SELECT * FROM `rooms` r WHERE r.`room_type_id` = {$roomtypeid} AND r.`available` = 1 AND r.`status` = 1;";
    $result = mysqli_query($this->con, $sql);

    return $result;
  }

  public function BookRoomManually($booker, $roomnumber, $room_cost, $days)
  {
    $checker = "SELECT id FROM `room_bookings` rb WHERE rb.`room_id` = {$roomnumber} AND 
    (NOW() BETWEEN rb.`arrival_date` AND rb.`departure_date` OR NOW() BETWEEN rb.`arrival_date` AND rb.`departure_date`) AND rb.`status` <> 'cancelled';";
    $checkerResult = mysqli_query($this->con, $checker);
    if (mysqli_num_rows($checkerResult) == 0) {
      $sql = "INSERT INTO `room_bookings` (booker,room_id,user_id,arrival_date,departure_date,room_cost)
    VALUES ('{$booker}',{$roomnumber},0,DATE(NOW()),DATE_ADD((DATE(NOW())), INTERVAL {$days} DAY),{$room_cost});";

      if ($this->con->query($sql) === TRUE) {
        echo "<script>
      alert('Booking Successful');
      window.location.href='addroom.php';
      </script>";
      } else {
        echo "<script>
      alert('Error Booking.');
      window.location.href='addmanuallyroom.php';
      </script>";
      }
    } else {
      echo "<script>
    alert('Date not available');
    window.location.href='addmanuallyroom.php';
    </script>";
    }
  }

  public function GetAllRoomItems()
  {
    $sql = "SELECT rb.id,r.`room_number`,DATE_FORMAT(DATE(rb.`arrival_date`), '%M %d,%Y') AS arrival_date,
    DATE_FORMAT(DATE(rb.`departure_date`), '%M %d,%Y') AS departure_date,rb.`room_cost`,rt.`name`, IF(rb.`user_id` = 0, rb.`booker`,
    (SELECT CONCAT_WS(' ',u.`first_name`,u.`last_name`) FROM users u WHERE u.id = rb.`user_id`)) AS `booker` FROM `room_bookings` rb
    JOIN `rooms` r  ON r.`id` = rb.`room_id`
    JOIN `room_types` rt ON rt.`id` = r.`room_type_id`
    WHERE rb.`id` NOT IN (SELECT p.item_id FROM `payments` p WHERE p.`paid_item_type` = 'room');";
    $result = mysqli_query($this->con, $sql);

    return $result;
  }

  public function SaveRoomPayment($id, $payment, $payment_type, $roomname)
  {
    $sql = "SELECT * FROM `room_bookings` WHERE `id` = " . $id . ";";
    $result = mysqli_query($this->con, $sql);

    $row = mysqli_fetch_assoc($result);
    if ($payment_type === "full_payment") {
      if ($row['room_cost'] > $payment) {
        echo "<script>
      alert('Payment Should be larger or equal to the price if full payment is selected.');
      window.location.href='addroom.php';
      </script>";
      } else {

        $addsql = "INSERT INTO `payments` (`booker_name`,`item_id`,`item_name`,`amount`,`payment_type`,`paid_item_type`)
                  VALUES ('{$row['booker']}',{$id}, '{$roomname}', {$row['room_cost']}, 1, 'room');";
        $updatesql = "UPDATE `room_bookings` SET payment = 2 WHERE id = {$id};";
        if ($this->con->query($addsql) === TRUE) {
          if ($this->con->query($updatesql) === TRUE) {
            echo "<script>
            alert('Payment Done');
            window.location.href='room.php';
          </script>";
          } else {
            echo "<script>
            alert('Error Updating Room Payment');
            window.location.href='room.php';
          </script>";
          }
        } else {
          echo "<script>
            alert('Error Adding Room Payment');
            window.location.href='addroom.php';
          </script>";
        }
      }
    } else {
      if ($payment >= $row['room_cost']) {
        echo "<script>
      alert('Payment Should be not be larger or equal to the price if partial payment is selected.');
      window.location.href='addroom.php';
      </script>";
      } else {
        $balance = $row['room_cost'] - $payment;
        $addsql = "INSERT INTO `payments` (`item_id`,`item_name`,`amount`,`payment_type`,`paid_item_type`,`remaining_balance`)
                  VALUES ({$id}, '{$roomname}', {$payment}, 0, 'room',{$balance});";
        $updatesql = "UPDATE `room_bookings` SET payment = 1 WHERE id = {$id};";
        if ($this->con->query($addsql) === TRUE) {
          if ($this->con->query($updatesql) === TRUE) {
            echo "<script>
          alert('Payment Done');
          window.location.href='room.php';
        </script>";
          } else {
            echo "<script>
          alert('Error Updating Room Payment');
          window.location.href='room.php';
        </script>";
          }
        } else {
          echo "<script>
          alert('Error Adding Room Payment');
          window.location.href='addroom.php';
        </script>";
        }
      }
    }
  }

  public function UpdateRoomPayment($id, $payment, $roombookingid, $balance)
  {
    if ($balance > $payment) {
      echo "<script>
    alert('Payment Should be larger or equal to the price is selected.');
    window.location.href='room.php';
    </script>";
    } else {
      $sql = "SELECT * FROM `room_bookings` WHERE `id` = " . $roombookingid . ";";
      $result = mysqli_query($this->con, $sql);

      $row = mysqli_fetch_assoc($result);
      $updatesql = "UPDATE `payments` SET amount = {$row['room_cost']}, payment_type = 1, remaining_balance = 0 WHERE id = {$id};";
      $updatebookingsql = "UPDATE `room_bookings` SET room_cost = {$row['room_cost']}, payment = 2 WHERE id = {$roombookingid};";
      if ($this->con->query($updatesql) === TRUE) {
        if ($this->con->query($updatebookingsql) === TRUE) {
          echo "<script>
        alert('Updating Payment Done');
        window.location.href='room.php';
      </script>";
        } else {
          echo "<script>
        alert('Error Updating Booking Updating Payments.');
        window.location.href='room.php';
      </script>";
        }
      } else {
        echo "<script>
      alert('Error Payment status.');
      window.location.href='room.php';
    </script>";
      }
    }
  }

  public function GetAllEntrance()
  {
    $sql = "SELECT p.*,ep.`no_of_adults`,ep.`no_of_children`,SUM(ep.`no_of_adults`+ep.`no_of_children`) as `total` FROM `payments` p 
    JOIN `entrance_and_pool` ep ON ep.`id` = p.`item_id`
    WHERE p.`paid_item_type` = 'entrance' GROUP BY ep.id;";
    $result = mysqli_query($this->con, $sql);

    return $result;
  }

  public function GetAllPool()
  {
    $sql = "SELECT p.*,ep.`no_of_adults`,ep.`no_of_children`,SUM(ep.`no_of_adults`+ep.`no_of_children`) as `total` FROM `payments` p 
      JOIN `entrance_and_pool` ep ON ep.`id` = p.`item_id`
      WHERE p.`paid_item_type` = 'pool' GROUP BY ep.id;";
    $result = mysqli_query($this->con, $sql);

    return $result;
  }

  public function AddEntrancePayment($payment, $name, $adults, $children)
  {
    $total = ($adults * 50) + ($children * 20);
    if ($total > $payment) {
      echo "<script>
    alert('Payment Should be larger or equal to the total amount needed.');
    window.location.href='entrance.php';
    </script>";
    } else {
      $event_pool_insert = "INSERT INTO `entrance_and_pool` (`name`,`no_of_adults`,`no_of_children`,`type`)
      VALUES ('{$name}', {$adults}, {$children},'entrance');";

      $payments_add = "INSERT INTO `payments` (`booker_name`,`item_name`,`amount`,`paid_item_type`,`item_id`) 
      VALUES ('{$name}','Entrance',{$total},'entrance',(SELECT id FROM `entrance_and_pool` WHERE `type`= 'entrance' ORDER BY id DESC LIMIT 1));";

      if ($this->con->query($event_pool_insert) === TRUE) {
        if ($this->con->query($payments_add) === TRUE) {
          echo "<script>
            alert('Adding Entrance payments Done');
            window.location.href='entrance.php';
          </script>";
        } else {
          echo "<script>
            alert('Error Adding to payments.');
            window.location.href='entrance.php';
          </script>";
        }
      } else {
        echo "<script>
            alert('Error Adding Entrance payments.');
            window.location.href='entrance.php';
          </script>";
      }
    }
  }

  public function AddPoolPayment($payment, $name, $adults, $children)
  {
    $total = ($adults * 100) + ($children * 50);
    if ($total > $payment) {
      echo "<script>
    alert('Payment Should be larger or equal to the total amount needed.');
    window.location.href='pool.php';
    </script>";
    } else {
      $event_pool_insert = "INSERT INTO `entrance_and_pool` (`name`,`no_of_adults`,`no_of_children`,`type`)
      VALUES ('{$name}', {$adults}, {$children},'pool');";

      $payments_add = "INSERT INTO `payments` (`booker_name`,`item_name`,`amount`,`paid_item_type`,`item_id`) 
      VALUES ('{$name}','Pool',{$total},'pool',(SELECT id FROM `entrance_and_pool` WHERE `type`= 'pool' ORDER BY id DESC LIMIT 1));";

      if ($this->con->query($event_pool_insert) === TRUE) {
        if ($this->con->query($payments_add) === TRUE) {
          echo "<script>
            alert('Adding Pool payments Done');
            window.location.href='pool.php';
          </script>";
        } else {
          echo "<script>
            alert('Error Adding to payments.');
            window.location.href='pool.php';
          </script>";
        }
      } else {
        echo "<script>
            alert('Error Adding Pool payments.');
            window.location.href='pool.php';
          </script>";
      }
    }
  }
}

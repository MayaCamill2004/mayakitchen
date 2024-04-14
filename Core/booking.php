<?php
class Booking {
    // Properties for database connection and table
    private $conn;
    private $table = 'bookings';

    // Properties of a booking
    public $id;
    public $user_id;
    public $table_id;
    public $date;
    public $time;
    public $party_size;
    public $review_id;
    public $preferences_id;
    public $discount_id;
    public $waitlist_id;

    // Constructor to initialize database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Method to retrieve all bookings
    public function read() {
        $query = 'SELECT * FROM ' . $this->table . ' ORDER BY booking_date DESC';

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Method to retrieve a single booking by ID
    public function read_single() {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ? LIMIT 0,1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->user_id = $row['user_id'];
        $this->date = $row['date'];
        $this->time = $row['time'];
        $this->party_size = $row['party_size'];
        $this->preferences_id = $row['preferences_id'];
        $this->discount_id = $row['discount_id'];
    }

    //create a new booking
    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' (user_id, date, time, party_size, preferences_id, discount_id) VALUES (:user_id, :date, :time, :party_size, :preferences_id, :discount_id)';
        $stmt = $this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->time = htmlspecialchars(strip_tags($this->time));
        $this->party_size = htmlspecialchars(strip_tags($this->party_size));
        $this->preferences_id = htmlspecialchars(strip_tags($this->preferences_id));
        $this->discount_id = htmlspecialchars(strip_tags($this->discount_id));
      
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':time', $this->time);
        $stmt->bindParam(':party_size', $this->party_size);
        $stmt->bindParam(':preferences_id', $this->preferences_id);
        $stmt->bindParam(':discount_id', $this->discount_id);
    

        if ($stmt->execute()) {
            return true;
        }

        printf('Error: %s. \n', $stmt->error);
        return false;
    }

    
   // update an existing booking
public function update() {
    $query = 'UPDATE ' . $this->table . ' SET user_id = :user_id, date = :date, time = :time, party_size = :party_size, preferences_id = :preferences_id, discount_id = :discount_id WHERE id = :id';

    $stmt = $this->conn->prepare($query);

    $this->id = htmlspecialchars(strip_tags($this->id));
    $this->user_id = htmlspecialchars(strip_tags($this->user_id));
    $this->date = htmlspecialchars(strip_tags($this->date));
    $this->time = htmlspecialchars(strip_tags($this->time));
    $this->party_size = htmlspecialchars(strip_tags($this->party_size));
    $this->preferences_id = htmlspecialchars(strip_tags($this->preferences_id));
    $this->discount_id = htmlspecialchars(strip_tags($this->discount_id));

    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':user_id', $this->user_id);
    $stmt->bindParam(':date', $this->date);
    $stmt->bindParam(':time', $this->time);
    $stmt->bindParam(':party_size', $this->party_size);
    $stmt->bindParam(':preferences_id', $this->preferences_id);
    $stmt->bindParam(':discount_id', $this->discount_id);

    if ($stmt->execute()) {
        return true;
    }

    printf('Error: %s. \n', $stmt->error);
    return false;
}

// Method to delete a booking
public function delete() {
    $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

    $stmt = $this->conn->prepare($query);

    $this->id = htmlspecialchars(strip_tags($this->id));

    $stmt->bindParam(':id', $this->id);

    if ($stmt->execute()) {
        return true;
    }

    printf('Error: %s. \n', $stmt->error);
    return false;
}



  // retrieve booking details by ID
public function getBookingDetails($id) {
    $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $booking_details = array(
        'id' => $row['id'],
        'user_id' => $row['user_id'],
        'date' => $row['date'],
        'time' => $row['time'],
        'party_size' => $row['party_size'],
        'preferences_id' => $row['preferences_id'],
        'discount_id' => $row['discount_id'],
    );

    return $booking_details;
}

}

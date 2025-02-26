
<?php
    // Database connection
    $dsn      = 'mysql:host=localhost;dbname=your_database';
    $username = 'your_username';
    $password = 'your_password';
    $options  = [];

    $pdo = new PDO($dsn, $username, $password, $options);

    $user = new User($pdo);

    // Register a new user
    if ($user->register('newuser', 'password123')) {
        echo "User registered successfully!";
    } else {
        echo "Failed to register user.";
    }

    // Login a user
    if ($user->login('newuser', 'password123')) {
        echo "Login successful! Welcome, " . $_SESSION['username'];
    } else {
        echo "Login failed.";
    }

    // Check if user is logged in
    if ($user->isLoggedIn()) {
        echo "User is logged in: " . $_SESSION['username'];
    } else {
        echo "User is not logged in.";
    }

    // Logout a user
    $user->logout();
    echo "User logged out.";
?>



<?php
    session_start();

    class User
    {
        private $db;

        public function __construct($pdo)
        {
            $this->db = $pdo;
        }

        // Register a new user
        public function register($username, $password)
        {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $sql            = "INSERT INTO users (username, password) VALUES (:username, :password)";
            $stmt           = $this->db->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);
            return $stmt->execute();
        }

        // Login a user and set session
        public function login($username, $password)
        {
            $sql  = "SELECT * FROM users WHERE username = :username";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Authentication successful, set session
                $_SESSION['user_id']  = $user['id'];
                $_SESSION['username'] = $user['username'];
                return true;
            } else {
                // Authentication failed
                return false;
            }
        }

        // Check if user is logged in
        public function isLoggedIn()
        {
            return isset($_SESSION['user_id']);
        }

        // Logout a user
        public function logout()
        {
            session_unset();
            session_destroy();
        }
    }
?>

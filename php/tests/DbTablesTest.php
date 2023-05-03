<?php
use PHPUnit\Framework\TestCase;

class DbTablesTest extends TestCase {
    public function testConection() {
        //tests general connection
        require 'tools/database.php';

        $stmt = $con->prepare("SELECT DATABASE();");
        $stmt->execute();
        $stmt->store_result();
        $conection = $stmt->num_rows;
        $stmt->close();
        $this->assertEquals(1, $conection);
    }
    // checks if tables exstist (does not check for collums)
    public function testBookcopy() {
        require 'tools/database.php';
        
        $table_name = 'bookcopy';
        $stmt = $con->prepare("SHOW TABLES LIKE '$table_name'");
        $stmt->execute();
        $stmt->store_result();
        $bookcopy = $stmt->num_rows;
        $stmt->close();
        $this->assertEquals(1, $bookcopy);
    }      
    public function testBooks() {
        require 'tools/database.php';
        
        $table_name = 'books';
        $stmt = $con->prepare("SHOW TABLES LIKE '$table_name'");
        $stmt->execute();
        $stmt->store_result();
        $books = $stmt->num_rows;
        $stmt->close();
        $this->assertEquals(1, $books);
    } 
    public function testLoan() {
        require 'tools/database.php';
        
        $table_name = 'loan';
        $stmt = $con->prepare("SHOW TABLES LIKE '$table_name'");
        $stmt->execute();
        $stmt->store_result();
        $loan = $stmt->num_rows;
        $stmt->close();
        $this->assertEquals(1, $loan);
    } 
    public function testLoanlog() {
        require 'tools/database.php';
        
        $table_name = 'loanlog';
        $stmt = $con->prepare("SHOW TABLES LIKE '$table_name'");
        $stmt->execute();
        $stmt->store_result();
        $loanlog = $stmt->num_rows;
        $stmt->close();
        $this->assertEquals(1, $loanlog);
    } 
    public function testAccounts() {
        require 'tools/database.php';
        
        $table_name = 'accounts';
        $stmt = $con->prepare("SHOW TABLES LIKE '$table_name'");
        $stmt->execute();
        $stmt->store_result();
        $accounts = $stmt->num_rows;
        $stmt->close();
        $this->assertEquals(1, $accounts);
    } 
}
?>

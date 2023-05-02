<?php
use PHPUnit\Framework\TestCase;

require 'tools/database.php';

class DbTablesTest extends TestCase {
    public function testTables() {
        global $con;
        
        $table_name = 'accounts';
        $stmt = $con->prepare('SHOW TABLES LIKE ?');
        $stmt->bind_param('s', $table_name);
        $stmt->execute();
        $stmt->store_result();
        $accounts = $stmt->num_rows;
        $stmt->close();
    
        $table_name = 'bookcopy';
        $stmt = $con->prepare('SHOW TABLES LIKE ?');
        $stmt->bind_param('s', $table_name);
        $stmt->execute();
        $stmt->store_result();
        $bookcopy = $stmt->num_rows;
        $stmt->close();
    
        $table_name = 'books';
        $stmt = $con->prepare('SHOW TABLES LIKE ?');
        $stmt->bind_param('s', $table_name);
        $stmt->execute();
        $stmt->store_result();
        $books = $stmt->num_rows;
        $stmt->close();
    
        $table_name = 'loan';
        $stmt = $con->prepare('SHOW TABLES LIKE ?');
        $stmt->bind_param('s', $table_name);
        $stmt->execute();
        $stmt->store_result();
        $loan = $stmt->num_rows;
        $stmt->close();
    
        $table_name = 'loanlog';
        $stmt = $con->prepare('SHOW TABLES LIKE ?');
        $stmt->bind_param('s', $table_name);
        $stmt->execute();
        $stmt->store_result();
        $loanlog = $stmt->num_rows;
        $stmt->close();
    
        $this->assertEquals(1, $accounts);
        $this->assertEquals(1, $bookcopy);
        $this->assertEquals(1, $books);
        $this->assertEquals(1, $loan);
        $this->assertEquals(1, $loanlog);
    }        
}
?>

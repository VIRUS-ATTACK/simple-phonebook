<?php
    require('sql_connect.php');
?>


<html>
    <h1 style="text-align:center;font-family:Roboto;color:#FFFFFF;">Phone book</h1>
    <h2 style="text-align:center;">Save contact</h2>
    <form action="phonebook.php" method="POST">
        <br>enter contact number : 
        <input type="number" name="c_number" min="100000" max="999999999999">
        <br><br>enter contact name :
        <input type="text" name="c_name"> 
        <br><input type="submit" value="submit">
    </form>

    <h2 style="text-align:center;">Search contact</h2>
    <form action="phonebook.php" method="POST">
        <br>enter name to search: <input type="text" name="search_contact">
        <br><input type="submit" value="submit">
    </form>
</html>


<?php
    function search_contact($name,$conn){
        $query = "select `phone no` from phonebook where name like'%".mysqli_real_escape_string($conn,$name)."%'";
        $query_run = mysqli_query($conn,$query);
        if($query_run){
            if(mysqli_num_rows($query_run)==NULL){
                echo 'No reslts found';
            }
            else{
                while($query_row = mysqli_fetch_assoc($query_run)){
                    $phone_no = $query_row['phone no'];
                    $full_name = mysqli_fetch_assoc(mysqli_query($conn,"select name from phonebook where `phone no`='".mysqli_real_escape_string($conn,$phone_no)."'"));
                    echo '<br>contact no of '.$full_name['name'].' is '.$phone_no;
                }
            }
        }
        else{
            echo '<br>'.mysqli_error($conn);
        }
    }

    function save_contact($name,$number,$conn){
        $query = "insert into phonebook values(NULL,'".mysqli_real_escape_string($conn,$name)."','".mysqli_real_escape_string($conn,$number)."')";
        if($query_run = mysqli_query($conn,$query)){
            echo '<br><br>contact saved!!!!';
        }
        else{
            echo '<br>'.mysqli_error($conn);
        }
    }

    if(isset($_POST['c_number']) && isset($_POST['c_name']) && !empty($_POST['c_number']) && !empty($_POST['c_name'])){
        save_contact(strtolower($_POST['c_name']),$_POST['c_number'],$conn); 
    }

    if(isset($_POST['search_contact']) && !empty($_POST['search_contact'])){
        $name = strtolower($_POST['search_contact']);
        search_contact($name,$conn);
    }
        
?>

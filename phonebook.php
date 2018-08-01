<?php
    require('sql_connect.php');
    if(isset($_POST['c_number']) && isset($_POST['c_name']) && !empty($_POST['c_number']) && !empty($_POST['c_name'])){
        save_contact(strtolower($_POST['c_name']),$_POST['c_number'],$conn); 
        exit;
    }

    if(isset($_POST['search_contact']) && !empty($_POST['search_contact'])){
        $name = strtolower($_POST['search_contact']);
        search_contact($name,$conn);
        exit;
    }
?>


<html>
    <head>
    <script>
            function insert(){
                if(window.XMLHttpRequest){
                    xmlhttp = new XMLHttpRequest();
                }
                else{
                    xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
                }
                xmlhttp.onreadystatechange = function(){
                    if(xmlhttp.readyState==4 && xmlhttp.status==200){
                        document.getElementById('contact_saved').innerHTML = xmlhttp.responseText;
                    }
                }
                parameters = 'c_number='+document.getElementById('sav_num').value+'&c_name='+document.getElementById('sav_nam').value;
                xmlhttp.open('POST','phonebook.php',true);
                xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
                xmlhttp.send(parameters);
            }
        </script>
        <script>
            function search(){
                if(window.XMLHttpRequest){
                    xmlhttp = new XMLHttpRequest();
                }
                else{
                    xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
                }
                xmlhttp.onreadystatechange = function(){
                    if(xmlhttp.readyState==4 && xmlhttp.status==200){
                        document.getElementById('contact_saved').innerHTML = xmlhttp.responseText;
                    }
                }
                parameters = 'search_contact='+document.getElementById('search_num').value;
                xmlhttp.open('POST','phonebook.php',true);
                xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
                xmlhttp.send(parameters);
            }
        </script>
    </head>
    <body>
    <h1 style="text-align:center;font-family:Roboto;color:#FFFFFF;">Phone book</h1>
    <h2 style="text-align:center;">Save contact</h2>
    
        <br>enter contact number : 
        <input type="number" id="sav_num" name="c_number" min="100000" max="999999999999">
        <br><br>enter contact name :
        <input type="text" id="sav_nam" name="c_name"> 
        <br><input type="button" value="submit" onclick="insert()">
        
    <h2 style="text-align:center;">Search contact</h2>
        <br>enter name to search: <input type="text" id="search_num" name="search_contact">
        <br><input type="button" value="submit" onclick="search()">
    
    <br>
        <div id="contact_saved">
        </div>
    <br>
    </body>
</html>


<?php
    function search_contact($name,$conn){
        $query = "select `phone no` from phonebook where name like '".mysqli_real_escape_string($conn,$name)."%'";
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

    
        
?>

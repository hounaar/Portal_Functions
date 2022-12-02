# Portal_Functions
This file contains some useful portal functions in PHP

## Usage
You need to downlaod the file and insert it into your main code first. After that, there are 2 files.
First the connection and then the library function which uses the connection file itself as well.

```php
include "connection.php";
include "library.php";
```

The codes are several functions such as:
```php
function signup($name,$id,$email,$password,$repeat_password,$tablename){}
function selector($id,$password,$tablename){}
function update($name,$id,$email,$tablename){}
function mail_for_change_password(user_email){}
function change_password($new_pass,$repeat_new_pass,$tablename){}
function logout(){}
function delete_account(tablename){}

```

These functions have their own usage however you need to be sure that

### All types, variables, tablenames, table records, tuples, html ```$_POST``` or ```$_GET``` name and methods are test files and you have to type and insert your own record. This code just make things easier for the main source which you have to include the library file as mentioned.

For example if we want to use selector, we have to have to set the ```selector()``` arguements on the order as mentioned. Here the order is based on ```name``,```id```,```email```,```password```,```repeat_password```,```tablename```. Of course ```tablename``` is quite important because it is your table.

the access can be set like this :
```php
include_once "connection.php"; /*AS I HAVE MENTIONED, CONNECTION FILE IS ESSENTIAL FOR THE CODE*/
$name = mysqli_real_escape_string($connection,$_POST['name']);
$id = mysqli_real_escape_string($connection,$_POST['id']);
$email = mysqli_real_escape_string($connection,$_POST['email']);
$password = mysqli_real_escape_string($connection,$_POST['password']);
$repeat_password = mysqli_real_escape_string($connection,$_POST['repeat_password']);

/*NOW FOR USING THE selector function we have to do this :*/
selector($name,$id,$email,$password,$repeat_password,$tablename);
```

#### Too easy. played with it like a violin and then cut the strings :))

I hope you have enjoyed it.






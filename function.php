<?php
include 'dbcon.php';

//Add Data into Customer Table
function error422 ($message): false|string
{
 $data = [
     'status' => 422,
     'message' => $message
 ];
 header ("HTTP/1.1 422 Unprocessable Entity");
 return json_encode($data);
 exit();
}
function storeCustomerData($customerInput)
{
global $conn;
$name = mysqli_real_escape_string($conn, $customerInput['name']);
$email = mysqli_escape_string($conn, $customerInput['email']);
$phone = mysqli_escape_string($conn, $customerInput['phone']);

if(empty(trim($name)))
{
    return error422('Enter your name');
}
elseif(empty(trim($email)))
{
    return error422('Enter your email');
}
elseif(empty(trim($phone)))
{
    return error422('Enter your phone');
}

else {
    $query = "INSERT INTO customers (name, email, phone) VALUES ('$name','$email','$phone')";
    $result = mysqli_query($conn, $query);
}
if($result)
{
    $data = [
        'status' => 201,
        'msg' => "Data Added succesfully",
    ];
    header("HTTP/1.1 201 Data Added succesfully");

    return json_encode($data);
}
else{
    $data = [
        'status' => 404,
        'msg' => "No Data Added succesfully",
    ];
    header("HTTP/1.1 404 No Data Added succesfully");

    return json_encode($data);
}
};

//Fetched single record

function dataById($customerParams)
{
    global $conn;

    if($customerParams['id'] == null)
    {
        return error422('Enter your id');
    }

    $customerId =mysqli_escape_string($conn, $customerParams['id']);

    $query = "select * from customers where id = '$customerId' LIMIT 1";
    $result = mysqli_query($conn, $query);
    if($result){

        if(mysqli_num_rows($result) == 1)
        {
            $row = mysqli_fetch_assoc($result);
            $data = [
                'status' => 200,
                'msg' => "Data Found",
                'data' => $row,
            ];
            header("HTTP/1.1 200 Data Found");
            return json_encode($data);


    }else{
        $data = [
            'status' => 404,
            'msg' => "No Data Found",
        ];
        header("HTTP/1.1 404 No Data Found");
        return json_encode($data);
        }
    }
    else{
        $data = [
            'status' => 500,
            'msg' => "Internal server error",
        ];
        header("HTTP/1.1 500 Internal server error");
        return json_encode($data);
    }




}
// Read Customer Table
function customerList(): false|string
{
    global $conn;
    $query = "select * from customers";
    $query_run = mysqli_query($conn, $query);

    if($query_run){
        if(mysqli_num_rows($query_run) > 0 )
        {
            $result = mysqli_fetch_all($query_run);
            $data = [
                'status' => 200,
                'msg' => "data found",
                'data' => $result,
            ];
            header("HTTP/1.1 200 data Found");
        }
        else{
            $data = [
                'status' => 404,
                'msg' => "data not found",
            ];
            header("HTTP/1.1 404 Not Found");
        }
    }
    else{
        $data = [
            'status' => 404,
            'msg' => "data not found",
        ];
        header("HTTP/1.1 404 Not Found");
    }
    return json_encode($data);

}

// Update Customer

function updateCustomer($customerInput, $customerParams)
{
    global $conn;
   if(!isset($customerParams['id']))
   {
       return error422("Customer Id not found");
   }
   elseif($customerParams['id'] == null) {
       return error422("Enter the customer id");
   }
        $customerId =mysqli_escape_string($conn, $customerParams['id']);
        $name = mysqli_escape_string($conn, $customerInput['name']);
        $email = mysqli_escape_string($conn, $customerInput['email']);
        $phone = mysqli_escape_string($conn, $customerInput['phone']);

        if(empty(trim($name)))
        {
            return error422('Enter your name');
        }
        elseif(empty(trim($email)))
        {
            return error422('Enter your email');
        }
        elseif(empty(trim($phone)))
        {
            return error422('Enter your phone');
        }
        else{
            $query = "UPDATE customers SET name = '$name', email = '$email', phone = '$phone' WHERE id = '$customerId' LIMIT 1";
            $result = mysqli_query($conn, $query);
            if($result)
            {

                    $data = [
                        'status' => 200,
                        'msg' => "Data Updated",

                    ];
                    header("HTTP/1.1 200 Data Updated");
                    return json_encode($data);

            }
            else{
                $data = [
                    'status' => 500,
                    'msg' => "Internal server error",
                ];
                header("HTTP/1.1 500 Internal server error");
                return json_encode($data);

            }
        }



}

//Delete the Customer Data

function deleteCustomer($customerParams)
{
    global $conn;

    if(!isset($customerParams['id']))
    {
        return error422("Customer Id not found");
    }
    elseif($customerParams['id'] == null){
        return error422("Enter the customer id");
    }
    $customerId =mysqli_escape_string($conn, $customerParams['id']);
    $query = "DELETE FROM customers WHERE id = '$customerId' LIMIT 1";
    $result = mysqli_query($conn, $query);
    if($result){
        $data = [
            'status' => 200,
            'msg' => "Data Deleted",
        ];
        header("HTTP/1.1 200 Data Deleted");
        return json_encode($data);
    }
    $data = [
        'status' => 404,
        'msg' => "Customer Not Found",
    ];
    header("HTTP/1.1 404 Customer Not Found");
    return json_encode($data);
}

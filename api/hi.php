<?php
require_once "koneksi.php"; //Require_once untuk menyertakan sebuah file PHP kedalam file PHP lainnya
   if(function_exists($_GET['function'])) { //Validasi function                        Mengembalikan nilai true jika fungsi ada dan merupakan fungsi, false jika tidak.
         $_GET['function']();
      }   
   function get_siswa()
   {
      global $connect;      
      $query = $connect->query("SELECT * FROM siswa");            
      while($row=mysqli_fetch_object($query)) //buat mengambil semua data di tb siswa
      {
         $data[] =$row;
      }
      $response=array( //buat ngasi tau apakah program telah berhasil 
                     'status' => 1, //angka pemberitahuan nggak ada sangkut pautnya
                     'message' =>'Success', //cuma message kok
                     'data' => $data //memunculkan apa saja yang diambil di tb_siswa
                  );
      header('Content-Type: application/json'); //Fungsi header() digunakan untuk mengirimkan header HTTP mentah ke klien.
      echo json_encode($response); //buat nampilin yang diresponse tu
   }   
   
   function get_siswa_id() //ini function buat ngambil data siswa di id tertentu
   {
      global $connect; //buat konek ke
      if (!empty($_GET["id"])) { //menentukan apakah sebuah variabel itu kosong ato tidak
         $id = $_GET["id"]; 
      }
      $query ="SELECT * FROM siswa WHERE id= $id";      
      $result = $connect->query($query);
      while($row = mysqli_fetch_object($result))
      {
         $data[] = $row;
      }            
      echo json_encode($data);
      if($data)
      {
      $response = array(
                     'status' => 1,
                     'message' =>'Success',
                     'data' => $data
                  );
      }else {
         $response=array(
                     'status' => 0,
                     'message' =>'No Data Found'
                  );
      }
      
      header('Content-Type: application/json'); //menunjuk konten dalam format JSON, dikodekan dalam pengkodean karakter UTF-8.
      echo json_encode($response);
       
   }
   function insert_siswa()
      {
         global $connect;   
         $check = array('nama' => '', 'jenis_kelamin' => '', 'alamat' => '', 'telp' => '');
         $check_match = count(array_intersect_key($_POST, $check)); //Menghitung persimpangan array menggunakan kunci untuk perbandingan
         
         if($check_match == count($check)){
         
               $result = mysqli_query($connect, "INSERT INTO siswa SET
               nama = '$_POST[nama]',
               jenis_kelamin = '$_POST[jenis_kelamin]',
               alamat = '$_POST[alamat]',
               telp = '$_POST[telp]'");

               mysqli_query($connect, "INSERT INTO tb_siswa SET
               nama = '$_POST[nama]',
               jenis_kelamin = '$_POST[jenis_kelamin]',
               alamat = '$_POST[alamat]',
               telp = '$_POST[telp]'");
               
               if($result)
               {
                  $response=array(
                     'status' => 1,
                     'message' =>'Insert Success'
                  );
               }
               else
               {
                  $response=array(
                     'status' => 0,
                     'message' =>'Insert Failed.'
                  );
               }
         }else{
            $response=array(
                     'status' => 0,
                     'message' =>'Wrong Parameter'
                  );
         }
         header('Content-Type: application/json');
         echo json_encode($response);
      }

   function update_siswa()
      {
         global $connect;
         if (!empty($_GET["id"])) {
         $id = $_GET["id"];    
      }   
      get_siswa_id();
         $check = array('nama' => '', 'jenis_kelamin' => '', 'alamat' => '', 'telp' => '');
         $check_match = count(array_intersect_key($_POST, $check));   

         if($check_match == count($check)){

              $result = mysqli_query($connect, "UPDATE siswa SET               
               nama = '$_POST[nama]',
               jenis_kelamin = '$_POST[jenis_kelamin]',
               alamat = '$_POST[alamat]',
               telp = '$_POST[telp]' 
               WHERE id = $id");

               mysqli_query($connect, "UPDATE tb_siswa SET
               nama = '$_POST[nama]',
               jenis_kelamin = '$_POST[jenis_kelamin]',
               alamat = '$_POST[alamat]',
               telp = '$_POST[telp]'
               WHERE id = $id");
         
            if($result)
            {
               $response=array(
                  'status' => 1,
                  'message' =>'Update Success'                  
               );
            }
            else
            {
               $response=array(
                  'status' => 0,
                  'message' =>'Update Failed'                  
               );
            }
         }else{
            $response=array(
                     'status' => 0,
                     'message' =>'Wrong Parameter',
                     'data'=> $id
                  );
         }
         header('Content-Type: application/json');
         echo json_encode($response);
      }
   function delete_siswa()
   {
      global $connect;
      $id = $_GET['id'];
      $query = "DELETE FROM siswa WHERE id= $id";
      $query2 = "DELETE FROM tb_siswa WHERE id= $id";
      if(mysqli_query($connect, $query))
      {
         mysqli_query($connect, $query2);
         $response=array(
            'status' => 1,
            'message' =>'Delete Success'
         );
      }
      else
      {
         $response=array(
            'status' => 0,
            'message' =>'Delete Fail.'
         );
      }
      header('Content-Type: application/json');
      echo json_encode($response);
   }
 ?>
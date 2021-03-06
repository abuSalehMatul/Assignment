<?php


class StudentController extends Controller
{

    protected $userModel;
    protected $mediaModel;
    protected $orderRequestModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
        if (!isset($_SESSION['user']) || $_SESSION['user'] == null) {
            $_SESSION['user'] = $this->userModel->findUserById($_SESSION['id']);
        }

        $this->mediaModel = $this->model('Media');
        $this->orderRequestModel = $this->model('OrderRequest');
        $this->chatRequestModel = $this->model('Chat');
    }

    public function __call($method, $arguments = [])
    {
        if (method_exists($this, $method)) {
            if (
                isset($_SESSION['id']) && $_SESSION['id'] != null &&
                isset($_SESSION['role']) && $_SESSION['role'] == 4
            ) {
                return call_user_func_array(array($this, $method), $arguments);
            } else {
                header("Location: " . URLROOT . "/" . $_SESSION['lang'] . "/auth/login");
            }
        }
    }

    private function validator($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    private function client_chat()
    {

//        $data['get_chat'] =
//            $this->chatRequestModel->getChatUserId($_SESSION['id']);
        $this->view('writer/client_chat');
    }

    private function adminChat($root, $url, $id)
    {

        $data['get_admin'] = $this->chatRequestModel->get_admin_id();

        $admin_id['data'] = [];
        foreach ($data['get_admin'] as $admins) {
            $admin = $this->chatRequestModel->get_admin_details_by_id($admins['user_id']);
            array_push($admin_id, $admin);
        }
//print_r($admin_id);
//        exit();

        $this->view('system_chat/admin_chat', $admin_id);
    }

    private function allChat()
    {
        $id = $_SESSION['id'];
        $data = [];
        $get = $this->chatRequestModel->getChatReceiverUserId($id);

        foreach ($get as $key => $val) {
            array_push($data, $val[0]);
        }
        $datas = array_unique($data);

        $get_data = [];
        foreach ($datas as $key => $val) {
            $info = $this->chatRequestModel->user_by_id($val);
            array_push($get_data, $info);
        }
        $this->view('student/all_chat', $get_data);
    }

    private function get_user_name_by_id($root, $url, $id)
    {
//        $id = $_SESSION['id'];
        $data =
            $this->chatRequestModel->user_by_id($id);
        echo json_encode($data);
    }

    private function insert_chat()
    {
        $data = array(
            'sender_id' => $_SESSION['id'],
            'message' => $_POST['message'],
            'receiver_id' => $_POST['receiver_id'],

        );
//        $sender_id = $_SESSION['id'];
//        $message = $this->input->post('message');
//        $receiver_id = $this->input->post('receiver_id');
        $this->chatRequestModel->saverecords($data);
        echo json_encode(array(
            "statusCode" => 200
        ));

    }

    private function fetch_user_chat_history()
    {

        $sender_id = $_SESSION['id'];
        $receiver_id = $_POST['receiver_id'];


        $result = $this->chatRequestModel->all_records($sender_id, $receiver_id);


        if ($result) {
            $output = '<li class="sent">';
            foreach ($result as $row) {
                $user_name = '';
                $chat_message = '';
                $login = strtotime($row['created_at']);
                $date = date('Y-m-d H:i:s');
                $data = strtotime($date);


                $diff = $data - $login;

                if ($diff > 86400) {
                    $time = round($diff / 86400) . " days ago";
                } elseif ($diff > 3600) {
                    $time = round($diff / 3600) . " hours ago";
                } else {
                    $time = round($diff / 60) . " minutes ago";
                }
                if ($row["sender_id"] == $sender_id) {

                    $chat_message = $row['message'];
                    if (strpos($chat_message, '.wav') !== false) {
                        $user_name = '<b class="text-success">You</b>';
                        $output .= '
	
			<audio controls preload="none">' . $user_name . ' - 
				<source src="' . URLROOT . '/uploads/' . $chat_message . '" type="audio/ogg">
					- <small><em>' . $time . '</em></small>
				</audio><br>
		
	
		';

                    } else {
                        $user_name = '<b class="text-success">You</b>';
                        $output .= '
	
			<p>' . $user_name . ' - ' . $chat_message . '
				<br>
					- <small><em>' . $time . '</em></small>
				</br></p><br>
		
	
		';
                    }

                } else {

                    $chat_message = $row["message"];

                    $user_name = $row["sender_id"];
                    $output .= '
	
			<p  style="margin-left: 400px">' . $this->get_user_name($user_name) . ' - ' . $chat_message . '
				<br>
					- <small><em>' . $time . '</em></small>
				</br></p><br>
		
	
		';

                }

            }
            $output .= '</li>';
            echo $output;
        } else {
            $output = '';
            echo $output;
        }

//        echo json_encode(array(
//            "statusCode" => 200
//        ));

    }

    function get_user_name($user_id)
    {

        $result = $this->chatRequestModel->get_user_name($user_id);

        return $result['f_name'] . ' ' . $result['l_name'];

    }

    private function draftSave()
    {
        if (!empty($_POST['token'])) {
            if (!hash_equals($_SESSION['token'], $_POST['token'])) {
                echo "un-authentic access.. ";
                die();
            }
        }

        if (
            $this->required($_POST['type']) && $this->required($_POST['page']) && $this->required($_POST['day'])
            && $this->required($_POST['lavel']) &&
            $this->required($_POST['service']
            )
        ) {
            $this->orderRequestModel->draftSave(
                $_SESSION['id'],
                $this->validator($_POST['type']),
                $this->validator($_POST['page']),
                $this->validator($_POST['lavel']),
                $this->validator($_POST['service']),
                $this->validator($_POST['language']),
                $this->validator($_POST['day']),
            );
            $price = $this->orderRequestModel->calculatePrice($_SESSION['draft_id']);
            $this->orderRequestModel->savePrices($_SESSION['draft_id'], $price);
            print_r($price);
        } else {
            print_r('all data required');
        }
    }


    private function OrderRequestsave()
    {
        if (!empty($_POST['token'])) {
            if (!hash_equals($_SESSION['token'], $_POST['token'])) {
                echo "un-authentic access.. ";
                die();
            }
        }
        if ($this->required($_POST['subject'])) {
            $this->orderRequestModel->onProcessSave(
                $_SESSION['draft_id'],
                $this->validator($_POST['subject']),
                $this->validator($_POST['style']),
                $this->validator($_POST['topic']),
                $this->validator($_POST['resource'])

            );
            header("Location: " . URLROOT . "/" . $_SESSION['lang'] . "/student/dashboard");
        } else {
            print_r('all data required');
        }
    }

    private function draft()
    {
        $this->data['draft'] = $this->orderRequestModel->getByStatusAndUser($_SESSION['id'], 'draft');
        $this->view('student/draft', $this->data, 'data');
    }

    private function inProgress()
    {
        $this->data['progress'] = $this->orderRequestModel->getByStatusAndUser($_SESSION['id'], 'progress');
        $this->view('student/progress', $this->data, 'data');
    }

    private function RequestDelete()
    {
        if (!empty($_POST['token'])) {
            if (!hash_equals($_SESSION['token'], $_POST['token'])) {
                return "un-authentic access.. ";
                die();
            }
        }

        if ($this->required($_POST['id'])) {
            return $this->orderRequestModel->deleteById($_POST['id']);
        }
    }

    private function StartOrderRequest()
    {
        $this->view('student/orderRequest');
    }

    private function imageStudent()
    {
        if (!empty($_POST['token'])) {
            if (!hash_equals($_SESSION['token'], $_POST['token'])) {
                echo "un-authentic access.. ";
                die();
            }
        }

        $this->userModel->editUser(
            $_SESSION['id'],
            $this->validator($_POST['f_name']),
            $this->validator($_POST['l_name']),
            $this->validator($_POST['email']),
            $this->validator($_POST['phone']),
            $this->validator($_POST['title']),
            $this->validator($_POST['description']),
        );
        header("Location: " . URLROOT . "/" . $_SESSION['lang'] . "/User/findProfile");
    }


    private function dashboard()
    {
        $this->data['total_order'] = $this->userModel->getTotalOrderByUserId($_SESSION['id']);
        $this->data['canceled_order'] = $this->userModel->getTotalCanceledOrderByUserId($_SESSION['id']);
        $this->data['completed_order'] = $this->userModel->getTotalCompletedOrderByUserId($_SESSION['id']);
        $this->data['order_request'] = $this->orderRequestModel->getByStatusAndUser($_SESSION['id'], 'progress');
        $this->view('student/dashboard', $this->data, 'data');
    }

    private function imageSave()
    {
        if (!empty($_POST['token'])) {
            if (!hash_equals($_SESSION['token'], $_POST['token'])) {
                echo "un-authentic access.. ";
                die();
            }
        }
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/public/imageUploads/";

        $fileName = time() . rand(20, 3000) . basename($_FILES["image"]["name"]);
        $db_dir = URLROOT . "/public/imageUploads/" . $fileName;
        $target_file = $target_dir . $fileName;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                //  echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }

        //Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["image"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $this->userModel->saveImage($_SESSION['id'], $db_dir);
                header("Location: " . URLROOT . "/" . $_SESSION['lang'] . "/User/findProfile");
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
}

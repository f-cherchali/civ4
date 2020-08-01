<?php
    namespace App\Models;
    use CodeIgniter\Model;
    class AdminModel extends Model{
        protected $table      = 'admin';
        protected $primaryKey = 'admin_id';

        protected $returnType     = 'object';
        protected $useSoftDeletes = true;

        protected $allowedFields = ['email', 'password', 'first_name', 'last_name', 'created_at', 'access_privileges', 'updated_at', 'role'];

        protected $useTimestamps = false;
        protected $createdField  = 'created_at';
        protected $updatedField  = 'updated_at';

        protected $validationRules    = [];
        protected $validationMessages = [];
        protected $skipValidation     = false;

        function checkAccountExists($email,$password){
            $db = \Config\Database::connect();
            $builder = $db->table("admin");
            $query = $builder->where([
                "email"=>$email
            ])->get();
            if($builder->countAllResults(false)>0){
                $row = $query->getResult()[0];
                $passhash = $row->password;
                if(password_verify($password,$passhash)){
                    return true;
                }
                return false;
            }
            return false;
        }
        function checkAccountActive($email){
            $db = \Config\Database::connect();
            $builder = $db->table("admin");
            $query = $builder->where([
                "email"=>$email,
                "active"=>"1"
            ])->get();
            if($builder->countAllResults(false)>0){
                return true;
            }
            return false;
        }
        function getAdminData($email){
            $db = \Config\Database::connect();
            $builder = $db->table("admin");
            $query = $builder->where("email",$email)->get();
            return $query->getResult()[0];
        }
        function checkAccountExistsToResetPassword($email){
            $db = \Config\Database::connect();
            $builder = $db->table("admin");
            $query = $builder->where([
                "email"=>$email
            ])->get();
            if($builder->countAllResults(false)>0){
                return true;
            }
            return false;
        }
        function setKeyRecover($email,$key){
            $db = \Config\Database::connect();
            $builder = $db->table("admin");
            $builder->set('keypass',$key,FALSE);
            $builder->where("email",$email);
            $builder->update();
        }
        function validKeyRecover($key){
            $db = \Config\Database::connect();
            $builder = $db->table("admin");
            $builder->where([
                "keyoass"=>$key,
                "active"=>"1"
            ])->get();
            if($builder->countAllResults()>0){
                return true;
            }
            return false;
        }
        function setRecoverNewPassword($hash_password,$key){
            $db = \Config\Database::connect();
            $builder = $db->table("admin");
            $builder->set([
                'password'=>$hash_password,
                'keypass'=>""],FALSE);
            $builder->where("keypass",$key);
            $builder->update();
        }
    }
?>
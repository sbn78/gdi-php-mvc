<?php
    class Blogger{
        /**
         * @static
         * @param int $limit
         * @return array|bool
         * Function gets all data about bloggers in database, ordered by username
         */
        public static function getAll () {

            //construct your SQL query-- select all the data about bloggers (every field), order the results by username (alphabetically),
            $sql = 'SELECT * FROM bloggers ORDER BY username DESC';
            //send that query to the Model class that Bloggers extends
            $results = Model::select($sql);
            //return results to controller
            return $results;
        }
        /**
         * @static
         * @param $id
         * @return array|bool
         * Function get all the data about one blogger if you know the blogger's id
         */
        public static function getOne($id){
            //construct your SQL query-- select all the data about one blogger by id
            $sql = 'SELECT * FROM bloggers WHERE id = '. $id . ' LIMIT 1';
            //send that query to the Model class that Bloggers extends
            $results = Model::select($sql);
            //return results to controller
            if($results){
                return $results[0];
            }
            else{
                return false;
            }
        }
        /**
         * @static
         * @param $fields
         * @return int
         * Insert data about a blogger into the database. This is a new blogger, because it creates a new row.
         */
        public static function create ($fields) {
            //set today's date and time
            $date = date ("Y-m-d H:i:s");
            ///clean all fields so they are not harmful to the database
            $fields = Model::cleanData($fields);
            ///scramble the password
            $password = md5($fields['password'], false);
            //construct sql query insert into the four database fields, the four values from our form
            $sql = 'INSERT INTO bloggers (username, email, password, date_created)
                   VALUES ("' . $fields['username'] . '", "' . $fields['email'] . '", "'. $password .'", "'. $date .'")';
            //send that query to the Model class that Bloggers extends
            $results = Model::insert($sql);
            //return results to controller
            return $results;
        }

        public static function edit ($fields, $id) {
             ///clean all fields so they are not harmful to the database
            $fields = Model::cleanData($fields);
            $hasPreviousField = false;
            //construct sql query to update username
            $sql = 'UPDATE bloggers SET';
            if($fields['username']!=''){
                $sql.= ' username = "' . $fields['username'] . '"';
                $hasPreviousField = true;
            }
            if($fields['email']!=''){
                if($hasPreviousField){
                    $sql .= ',';
                }
                $sql.= ' email = "' . $fields['email'] . '"';
                $hasPreviousField = true;
            }
            if($fields['password']!=''){
                if($hasPreviousField){
                    $sql .= ',';
                }
                $password = md5($fields['password'], false);
                $sql.= ' password = "' . $password . '"';
            }
            $sql .= ' WHERE id = ' . $id;
            $results = Model::update($sql);
           //return results to controller
           return $results;
        }

        public static function destroy ($id) {
            //construct query to delete
            $sql = 'DELETE FROM bloggers WHERE id = ' . $id;
            //send that query to the Model class that Bloggers extends
            $results = Model::delete($sql);
            //return results to controller
            return $results;
        }

        public static function login ($fields){
            $fields = Model::cleanData($fields);
            //construct your SQL query-- select all the data about one blogger by id
            $password = md5($fields['password'], false);
            $sql = 'SELECT * FROM bloggers WHERE username = "'. $fields['username'] . '" and password = "' .$password. '"  LIMIT 1';
            //send that query to the Model class that Bloggers extends
            $results = Model::select($sql);
            //return results to controller
            if($results){
                return $results[0];
            }
            else{
                return false;
            }


        }
    }
?>
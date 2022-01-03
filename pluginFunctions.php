<?php




function getPostsFromDB() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . "insta_posts"; 
    $vals = $wpdb->get_results('SELECT * FROM '.$table_name.';');
    // $vals = (array)$vals;

    $newarray = [];

    foreach ($vals as $key => $value) {
        $value = (array)$value;
        array_push($newarray, $value);
    }
    return $newarray;
}


function whileDeactivatingPlugin() {
    // truncate the table
    global $wpdb;
    
    $table_name = $wpdb->prefix . "insta_posts"; 
    $vals = $wpdb->query('TRUNCATE TABLE '.$table_name.';');
}


function createTableInstagramH() {
    // while activating plugin table will be created
    global $wpdb;
    
   $table_name = $wpdb->prefix . "insta_posts"; 

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        `id` INT(16) NOT NULL AUTO_INCREMENT,
        `post_id` VARCHAR(50) NOT NULL UNIQUE,
        `image_url` VARCHAR(2000),
        `time` DATETIME,
        `include` TINYINT DEFAULT 0,
        `type` VARCHAR(100),
        PRIMARY KEY (`id`)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    }


    function test() {
        echo get_option( 'access_token');
    }


    function getFirstPosts() {
        $accessToken = get_option( 'access_token');

        $post = [
            'fields' => 'id,username,timestamp,media_type,media_url',
            'access_token' => $accessToken,
        ];

        $data = http_build_query($post);
        $url = 'https://graph.instagram.com/me/media';
        $getUrl = $url . "?" . $data;
        $ch = curl_init($getUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        $array = json_decode($response, true);

        return $array;

    }


    function insertIntoTableFirstPosts($arr){
    
        global $wpdb;
        $table = $wpdb->prefix.'insta_posts';

        foreach ($arr as $key => $value) {

            $data = [
                'post_id' => $value['id'],
                'image_url' => $value['media_url'],
                'time' => $value['timestamp'],
                'type' => $value['media_type']
            ];

            $format = ['%s', '%s', '%s', '%s'];
            $wpdb->insert($table,$data,$format);
            // $my_id = $wpdb->insert_id;
        }
    }

    if(isset($_POST['postSettings'])) {
        $abc = $_POST['myarray'];

        $newArray = JSON_decode($abc);
        // echo '<pre>';
        // print_r($newArray);
        UpdatePostsRequirements($newArray);
    }




    function UpdatePostsRequirements($arr) {
        global $wpdb;
        $table = $wpdb->prefix.'insta_posts';

        // echo '<pre>';
        //     print_r($arr) ;

        foreach ($arr as $key => $value) {

 

            $dataArr = [
                'include' => $value[1]
            ];

            $wherecluaseArr = [
                'post_id' => $value[0]
            ];

            $wpdb->update($table, $dataArr, $wherecluaseArr);
        }

        // Locate to plugin page
        $referer = site_url().'/wp-admin/admin.php?page=instah_slg';
        header("Location: $referer");

    }



    function shortcodeCallback() {

        $mydata = getPostsFromDB();

        $postWidth = get_option( 'number_of_cols' );
        $rowGap = get_option( 'gap_between_rows' );
        $columnGap = get_option( 'gap_between_cols' );
        

      
        ob_start();

        ?>

        <style>
        #my-shortcode-container  {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            width: 100%;

        }
    </style>

        <div id="my-shortcode-container" style=" <?php echo 'row-gap: '.$rowGap. 'px; column-gap: '. $columnGap.'px;' ;  ?> ">
        <?php

        foreach ($mydata as $key => $value) {


            if($value['include'] == 1) { ?>

                <div class="post-item">
                    <a target="_blank" href="<?php echo $value["image_url"] ; ?> ">
                        <?php if($value["type"]== "IMAGE") { ?>
                            <img  width="<?php echo $postWidth ;?>" height="<?php echo $postWidth ;?>" src="<?php echo $value["image_url"] ;  ?>">
                        <?php 
                        }

                        else { ?>

                        <video width="<?php echo $postWidth ;?>" height="<?php echo $postWidth ;?>" class=""  controls>
                            <source src=" <?php echo $value["image_url"] ?> " type="video/mp4">
                            <source src=" <?php echo $value["image_url"] ?> " type="video/ogg">
                            Your browser does not support the video tag.
                        </video>

                        <?php 

                        }?>
                        
                    </a>
                </div>

                <?php

            }

            else {
                continue;
            }
                   
            ?>

         <?php } ?>   

        </div>

    


      
    <?php
	
	return ob_get_clean();


    }






?>


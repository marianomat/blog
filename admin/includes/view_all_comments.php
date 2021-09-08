 <table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Autor</th>
            <th>Comment</th>
            <th>Email</th>
            <th>Status</th>
            <th>In response to</th>
            <th>Date</th>
            <th>Approve</th>
            <th>Unapprove</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if(isset($_GET["p_id"])) {
                $post_id = $_GET["p_id"]; 
                $post_id = mysqli_real_escape_string($connection, $post_id);
                $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                $redirect = "p_id=$post_id";
            } else {
                $redirect = "";
                $query = "SELECT * FROM comments";
            }
            
            $select_comments = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($select_comments)) {
                $comment_id = $row["comment_id"];
                $comment_autor = $row["comment_autor"];
                $comment_content = $row["comment_content"];
                $comment_email = $row["comment_email"];
                $comment_status = $row["comment_status"];
                $comment_post_id = $row["comment_post_id"];
                $comment_date = $row["comment_date"];


                echo "<tr>";
                echo "<td>$comment_id</td>";
                echo "<td>$comment_autor</td>";
                echo "<td>$comment_content</td>";
                echo "<td>$comment_email</td>";
                echo "<td>$comment_status</td>";

                $query = "SELECT * FROM posts WHERE post_id = $comment_post_id;";
                $select_post = mysqli_query($connection, $query);
                while($row = mysqli_fetch_assoc($select_post)) {
                    $post_id = $row["post_id"];
                    $post_title = $row["post_title"];
                }  
                echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
                echo "<td>$comment_date</td>";
                echo "<td><a href='comments.php?approve={$comment_id}&$redirect'>Approve</a></td>";
                echo "<td><a href='comments.php?unapprove={$comment_id}&$redirect'>Unapprove</a></td>";
                echo "<td><a href='comments.php?delete_comment={$comment_id}&$redirect'>Delete</a></td>";
                echo "</tr>";

            }
        ?>
    </tbody>
</table>

<?php 
    if(isset($_GET["delete_comment"])) {
        $comment_id_to_delete = mysqli_real_escape_string($connection, $_GET["delete_comment"]);
        $query = "DELETE FROM comments WHERE comment_id = $comment_id_to_delete";
        $delete_query = mysqli_query($connection, $query);
        header("Location: comments.php?$redirect"); 
    }

    if(isset($_GET["unapprove"])) {
        $comment_id_to_unapprove = mysqli_real_escape_string($connection, $_GET["unapprove"]);
        $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $comment_id_to_unapprove";
        $unapprove_query = mysqli_query($connection, $query);
        header("Location: comments.php?$redirect"); 
    }

    if(isset($_GET["approve"])) {
        $comment_id_to_approve = mysqli_real_escape_string($connection, $_GET["approve"]);
        $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $comment_id_to_approve";
        $approve_query = mysqli_query($connection, $query);
        header("Location: comments.php?$redirect"); 
    }
?>
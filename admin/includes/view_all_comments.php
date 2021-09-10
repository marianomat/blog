 <table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Autor</th>
            <th>Comentario</th>
            <th>Email</th>
            <th>Estado</th>
            <th>En respuesta de</th>
            <th>Fecha</th>
            <th>Apobrar</th>
            <th>Desarpobar</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if(isset($_GET["p_id"])) {
                $post_id = $_GET["p_id"]; 
                $query = "SELECT comment_id, comment_autor, comment_content, comment_email, comment_status, comment_post_id, comment_date 
FROM comments WHERE comment_post_id = ?";
                $stmt = mysqli_prepare($connection, $query);
                mysqli_stmt_bind_param($stmt, "i", $post_id);

                $redirect = "p_id=$post_id";
            } else {
                $redirect = "";
                $query = "SELECT comment_id, comment_autor, comment_content, comment_email, comment_status, comment_post_id, comment_date, post_id, post_title 
FROM comments INNER JOIN posts ON post_id = comment_post_id";
                $stmt = mysqli_prepare($connection,$query);
            }
            
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $comment_id, $comment_autor, $comment_content,
                $comment_email, $comment_status, $comment_post_id, $comment_date, $post_id, $post_title);

            while(mysqli_stmt_fetch($stmt)) {
                echo "<tr>";
                echo "<td>$comment_id</td>";
                echo "<td>$comment_autor</td>";
                echo "<td>$comment_content</td>";
                echo "<td>$comment_email</td>";
                echo "<td>$comment_status</td>";
                echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
                echo "<td>$comment_date</td>";
                echo "<td><a class='btn btn-sm btn-info' href='comments.php?approve={$comment_id}&$redirect'>Aprobar</a></td>";
                echo "<td><a class='btn btn-sm btn-info' href='comments.php?unapprove={$comment_id}&$redirect'>Desaprobar</a></td>";
                echo "<td><a class='btn btn-sm btn-danger' href='comments.php?delete_comment={$comment_id}&$redirect'>Eliminar</a></td>";
                echo "</tr>";
            }
            mysqli_stmt_close($stmt);
        ?>
    </tbody>
</table>

<?php 
    if(isset($_GET["delete_comment"])) {
        $comment_id_to_delete =$_GET["delete_comment"];
        $query = "DELETE FROM comments WHERE comment_id = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "i", $comment_id_to_delete);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: comments.php?$redirect");
    }

    if(isset($_GET["unapprove"])) {
        $comment_id_to_unapprove = $_GET["unapprove"];
        $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = ?";
        $stmt = mysqli_prepare($connection,$query);
        mysqli_stmt_bind_param($stmt,"i", $comment_id_to_unapprove);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: comments.php?$redirect");
    }

    if(isset($_GET["approve"])) {
        $comment_id_to_approve = $_GET["approve"];
        $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = ?";
        $stmt = mysqli_prepare($connection,$query);
        mysqli_stmt_bind_param($stmt,"i", $comment_id_to_approve);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: comments.php?$redirect"); 
    }
?>
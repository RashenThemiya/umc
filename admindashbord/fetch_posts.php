<?php
include 'db.php';

// Function to fetch posts
function fetchPosts($conn) {
    $output = '<table id="postList">';
    $output .= '<tr><th>Title</th><th>Description</th><th>Image</th><th>Action</th></tr>';
    $sql = "SELECT * FROM healthy_life";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $output .= '<tr>';
            $output .= '<td>'.$row["title"].'</td>';
            $output .= '<td>'.$row["description"].'</td>';
            $imageData = base64_encode($row["image"]);
            $src = 'data:image/jpeg;base64,'.$imageData;
            
            // Handle errors in getting image dimensions
            $dimensions = @getimagesizefromstring(base64_decode($imageData));
            if ($dimensions !== false && is_array($dimensions) && count($dimensions) >= 2) {
                $width = $dimensions[0];
                $height = $dimensions[1];
                
                // Calculate proportional dimensions
                $maxWidth = 100; // Set your maximum width
                $maxHeight = 100; // Set your maximum height
                $aspectRatio = $width / $height;
                $newWidth = min($width, $maxWidth);
                $newHeight = min($height, $maxHeight);
                if ($aspectRatio > 1) {
                    $newHeight = $newWidth / $aspectRatio;
                } else {
                    $newWidth = $newHeight * $aspectRatio;
                }
                
                // Output image with calculated dimensions
                $output .= '<td><img src="'.$src.'" style="width:'.$newWidth.'px; height:'.$newHeight.'px;" /></td>';
            } else {
                // Handle error: unable to get image dimensions
                $output .= '<td>Error: Unable to load image</td>';
            }
            $output .= '<td><button class="deleteBtn" data-postid="'.$row["tip_id"].'" style="padding: 8px 15px; background-color: #4bd969; color: white; border: none; border-radius: 5px; cursor: pointer;">Delete</button></td>';
            $output .= '</tr>';
        }
    } else {
        $output .= '<tr><td colspan="4">No posts found</td></tr>';
    }
    $output .= '</table>';
    echo $output;
}

// Fetch posts
fetchPosts($conn);
?>

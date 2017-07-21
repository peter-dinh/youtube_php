<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<?php 
	if(isset($_GET['id']))
	{
		$id = $_GET['id'];
		$c = 'https://www.googleapis.com/youtube/v3/videos?id='.$id.'&key=AIzaSyBZtN5WBJ9kRMpAcC5Yv6VxfQrn1OGBPhU&part=snippet,statistics&fields=items(id,snippet,statistics)';
		$json = file_get_contents($c); //lấy nội dung page json đổ vào biến
		$json = json_decode($json, true);
		$title = $json['items']['0']['snippet']['title'];
		$view = $json['items']['0']['statistics']['viewCount'];
?>
<div class="title" style="font-weight:bold; width: 560px; text-align: center; font-size: 25px;margin-bottom: 20px;"><?php echo $title; ?></div>
<div class="video"><iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $id ?>" frameborder="0" allowfullscreen></iframe></div>
<div class="view" style="font-weight:bold; width: 560px; text-align: right; font-size: 18px; margin-top: 10px;"><?php echo number_format($view)." lượt xem"; ?></div>
<?php
	}
?>
</body>
</html>
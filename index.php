<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Tìm kiếm video</title>
</head>

<body>
<form method="post">
	<table width="856" border="0">
	  <tbody>
		<tr>
		  <td colspan="2"><img src="logo.jpg" width="850" height="280" alt=""/></td>
		</tr>
		<tr>
		  <td width="119"><strong>Từ khóa</strong></td>
		  <td><input type="text" name="keyword" style="width: 500px" required></td>
		</tr>
		<tr>
		  <td><strong>Số lượng</strong></td>
		  <td><input type="number" max="10" min="1" name="number" required></td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
		  <td><input type="submit" name="search" value="Tìm kiếm" ></td>
		</tr>
	  </tbody>
	</table>
</form>
<?php 
	if(isset($_POST['search']))
	{
		include('simple_html_dom.php');
		$tim = str_replace(' ', '+', $_POST['keyword'], $count);
		$url = 'https://www.youtube.com/results?search_query='.$tim;
		$html = file_get_html($url);
		for( $i = 0 ;$i < $_POST['number']; $i++)
		{
			$noidung = $html->find('.yt-lockup-title',$i);
			foreach($noidung->find('a') as $element) 
				 $link = 'http://youtube.com'.$element->href;
			$result = str_replace('http://youtube.com/watch?v=', '', $link, $count);
			$c = 'https://www.googleapis.com/youtube/v3/videos?id='.$result.'&key=AIzaSyBZtN5WBJ9kRMpAcC5Yv6VxfQrn1OGBPhU&part=snippet,statistics&fields=items(id,snippet,statistics)';
			
			$json = file_get_contents($c);
			$json = json_decode($json, true);
			$id_video = $json['items']['0']['id'];
			$img = $json['items']['0']['snippet']['thumbnails']['medium']['url'];
			$title = $json['items']['0']['snippet']['title'];
			$like = $json['items']['0']['statistics']['likeCount'];
			$dislike = $json['items']['0']['statistics']['dislikeCount'];
		?>
		<table width="862" height="107" border="0">
		  <tbody>
			<tr>
			  <td width="182" rowspan="3"><img src="<?php echo $img; ?>" width="320" height="180" alt=""/></td>
			  <td colspan="4"><div style="margin-left: 10px; font-weight: bold; font-size: 25px;"><a href="view.php?id=<?php echo $id_video; ?>"><?php echo $title; ?></a></div></td>
			</tr>
			<tr>
			  <td colspan="4"><div style="margin-left: 20px; font-weight: bold; font-size: 23px;"><?php if(isset($json['items']['0']['statistics']['viewCount'])) echo number_format($json['items']['0']['statistics']['viewCount']). " lượt xem"; else "Đang cập nhập" ?></div></td>
			</tr>
			<tr>
			  <td width="80"><img src="like.png" width="30" height="30" style="margin-left: 50px" alt="like"/></td>
			  <td width="290"><?php  echo number_format($like); ?></td>
			  <td width="46"><img src="dislike.jpg" width="30" height="30" alt=""/></td>
			  <td width="242"><?php echo number_format($dislike); ?></td>
			</tr>
		  </tbody>
		</table>


<?php
		}
	}
?>

<br />
Được viết bởi <a href="http://www.writecodetolife.tk/">Peter Dinh</a>
</body>
</html>
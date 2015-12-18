<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
            <div style="padding:20px 46px;margin:0 auto;width:595px;">
				
				<div style="clear:both;" >	
					<p>Hi,<strong> Admin</strong>, </p>
                                        <p>
                                            Anda mendapatkan email terkait user : <?php echo $user ?> yang telah memasang iklan mobil baru di RajamMobil.com.<br/>
                                            Berikut detail iklan nya :<br/>
                                            ID : <?php echo $model->id ?><br/>
                                            Judul : <?php echo $model->title ?>
                                        </p>
					<div style="clear:both;"></div>
				</div>
            </div>
    </body>
</html>

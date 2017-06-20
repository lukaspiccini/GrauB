<?php
	$msg = "";
	if(isset($_POST['upload']))
	{
		$local = "imagens/".basename($_FILES['imagem']['name']);
		$db = mysqli_connect("localhost","root","","ia");
		
		$caminho = $_FILES['imagem']['name'];
		$desc1 = $_POST['desc1'];
		$desc2 = $_POST['desc2'];
		$desc3 = $_POST['desc3'];		
		
		$sql = "INSERT INTO imagens (caminho,desc1,desc2,desc3) VALUES ('$caminho','$desc1','$desc2','$desc3')";
		mysqli_query($db,$sql);
		
		if(move_uploaded_file($_FILES['imagem']['tmp_name'], $local))
		{
			$msg = "Upload realizado com sucesso.";
		}
		else
		{
			$msg = "Problema ao dar upload na imagem.";
		}
		
	}
?>


<!DOCTYPE html>
<html>
	<head>
		<title>Trabalho IA</title>
		
		<style>
			#geral
			{
				width: 100%;
				text-align: center;
			}
		
			#container
			{
				width: 50%;
				height: 600px;
				margin-top: 50px;
				margin-bottom: 20px;
				position:relative;
				border-radius: 25px;
				display: inline-block;
				float: left;
			}
			
			#insereImagem
			{
				
			}
			
			#chatBot
			{
				width: 100%;
				height: 45%;
				border-radius: 25px;
				background-color: lightgrey;
			}
			
			#botImage
			{
				margin-left: 15px;
				margin-top: 20px;
				float: left;
			}
			
			#botImage h1
			{
				margin-top: -10px;
				font-size: 30px;
				text-align: center;
			}
			
			#botTextArea
			{
				margin-top: 15px;
				margin-left: 30px;
				width: 65%;
				height: 200px;
			}
			
			#opcoes
			{
				padding: 20px;
				text-align: center;
			}
			
			#userMessage
			{
				width: 100%;
				height: 45%;
				border-radius: 25px;
				position:absolute;
				bottom:0;
				background-color: lightgrey;
			}
			
			#userImage
			{
				margin-left: 15px;
				margin-top: 20px;
				float: left;
			}
			
			#userImage h1
			{
				margin-top: -3px;
				font-size: 30px;
				text-align: center;
			}
			
			#userTextArea
			{
				margin-top: 20px;
				margin-left: 30px;
				width: 65%;
				height: 200px;
			}
			
			#botaoResposta
			{
				margin-top: 15px;
				margin-right: 43px;
				float: right;
			}
			
			#imagemQuestao
			{	
				width: 48%;
				height: 600px;
				background-color: lightgrey;
				display: inline-block;
				margin-left: 20px;
				margin-top: 50px;
				margin-bottom: 20px;
				float: right;
				border-radius: 25px;
			}
			
		</style>
		
	</head>
	
	
	<body onload="bemVindo()">
		<script type="text/javascript">
			var descricao1;
			var descricao2;
			var descricao3;

			digita = function(obj,text,callback)
			{ 
				/* faz efeito de digitação no texto. By Micox - elmicox.blogspot.com */
				obj = obj.nodeName ? obj : document.getElementById(obj);
				var len=obj.innerHTML.length;
				
				if(len<text.length)
				{
					obj.innerHTML = text.substring(0,len+1)
					setTimeout(function(){digita(obj,text,callback)},10);
					if(len==text.length-1 && callback){ callback();}
				}
			}
			
			function adicionaImagem()
			{
				if(document.getElementById("file").type == "file")
				{
					document.getElementById("file").type = "hidden";
					document.getElementById("text1").type = "hidden";
					document.getElementById("text2").type = "hidden";
					document.getElementById("text3").type = "hidden";
					document.getElementById("enviarForm").type = "hidden";
				}
						
				else if(document.getElementById("file").type == "hidden")
				{
					document.getElementById("file").type = "file";
					document.getElementById("text1").type = "text";
					document.getElementById("text2").type = "text";
					document.getElementById("text3").type = "text";
					document.getElementById("enviarForm").type = "submit";
				}
			}
			
			function alteraImagem()
			{
				document.getElementById("botTextArea").value = 'Boa Sorte!';

				{
					<?php
						$db = mysqli_connect("localhost","root","","ia");
						$sql = "SELECT * FROM imagens ORDER BY RAND() LIMIT 1";
						$result =  mysqli_query($db,$sql);
						while($row = mysqli_fetch_array($result))
						{ 
							echo "document.getElementById('teste').src = 'imagens/".$row['caminho']."';";
					?>

							descricao1 = "<?php echo $row['desc1'] ?>";
							descricao2 = "<?php echo $row['desc2'] ?>";
							descricao3 = "<?php echo $row['desc3'] ?>";
					<?php
						}
					?>
				}
			}

			function verificaResposta()
			{
				if(document.getElementById("userTextArea").value == descricao1 || document.getElementById("userTextArea").value == descricao2 || document.getElementById("userTextArea").value == descricao3)
				{
					document.getElementById("chatBot").style.backgroundColor = "green";
					document.getElementById("botTextArea").value = 'Parabéns! Você acertou a resposta. Aposto que anda estudando muito, continue assim!';
				}
				else
				{
					document.getElementById("chatBot").style.backgroundColor = "red";
					document.getElementById("botTextArea").value = 'Infelizmente você não acertou desta vez, mas não fique triste, continue com os estudos que você acertará na próxima!';
				}

			}

			function bemVindo()
			{
				digita('botTextArea','Olá, seja bem-vindo ao GrauB BOT, um Bot que irá lhe ajudar a aprender novos idiomas! Para iniciar a diversão é simples. Basta clicar em Proxima Imagem e uma imagem aleatória irá aparecer no lado direito da tela, após isto, basta digitar o que a imagem representa no campo de texto do usuário! Divirta-se e boa sorte nos estudos! 🙂');
			}
			
		</script>
	
		<div id="geral">
			<div id="container">
				<div id="chatBot">
					<div id="botImage">
						<img src="botImage.PNG" alt="Bot Image" width="200" height="200">
						<h1>GrauB BOT</h1>
					</div>
					
					<div id="botText">
						<textarea readonly id="botTextArea">
						</textarea>
					</div>
					
				</div>
				
						
				<div id="opcoes">
					<button name="proximaImagem" onclick="alteraImagem()">Proxima Imagem</button>
					<button name="adicionarImagem" onclick="adicionaImagem()">Adicionar Imagem</button>
					<button name="paginaInicial">Pagina Inicial</button>
				</div>
				
				
				<div id="userMessage">
					<div id="userImage">
						<img src="userImage.PNG" alt="Bot Image" width="200" height="200">
						<h1>User</h1>
					</div>
					
					<div id="userText">
						<input type="text" id="userTextArea">
					</div>
					
					<button id="botaoResposta" name="enviarResposta" onclick="verificaResposta()">Enviar</button>
				</div>
			</div>
		
			<div id="imagemQuestao">
				<img id="teste" src="botImage.PNG" width="500" height="600">
			</div>
			
			<div id="insereImagem">
				<form method="post" action="index.php" enctype="multipart/form-data">
					<div>
						<input id="file" type="hidden" name="imagem">
					</div>
					
					<div>
						<input id="text1" type="hidden" name="desc1">
					</div>
					
					<div>
						<input id="text2" type="hidden" name="desc2">
					</div>
					
					<div>
						<input id="text3" type="hidden" name="desc3">
					</div>
					
					<div>
						<input id="enviarForm" type="hidden" name="upload" value="Upload Imagem">
					</div>
				</form>
			</div>
		</div>
		
	</body>
</html>
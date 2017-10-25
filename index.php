<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>MapMaker</title>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/bootstrap-slider.min.css">
		<script src="js/jquery.min.js" type="text/javascript"></script>
		<script src="js/bootstrap.min.js" type="text/javascript"></script>
		<script src="js/bootstrap-slider.min.js" type="text/javascript"></script>
		<script src="js/p5.min.js" type="text/javascript"></script>
		<script src="class/Block.js" type="text/javascript"></script>
		<script src="class/Map.js" type="text/javascript"></script>
		<script src="class/NoiseMap.js" type="text/javascript"></script>
		<script>
		var infoShow = false;
		var levelShow = false;
		var baseShow = false;
		var menuIsMoving = false;
		<?php
			$layers = array('elevation','dryness','forest','color');
			forEach($layers as $layer){
				echo "var ".$layer."Show = false;\n";
			}
		?>
			function setNoiseValue(){
				$('#seed').html(m.seed);
				$('#waterLevel').val(m.waterLevel);
				$('#scl').val(scl);
				$('#w').val(w);
				$('#h').val(h);
				
				$('#forestInBrush').val(m.forestInBrush);
				$('#forestInGrass').val(m.forestInGrass);
				$('#forestInSavana').val(m.forestInSavana);
				
				$('#firstElevationBlock').val(m.firstElevationBlock);
				$('#secondElevationBlock').val(m.secondElevationBlock);
				$('#thirdElevationBlock').val(m.thirdElevationBlock);

				$('#drynessLimitBeach').val(m.drynessLimitBeach);

				$('#drynessLimitGrass').val(m.drynessLimitGrass);
				$('#drynessLimitBrush').val(m.drynessLimitBrush);
				$('#drynessLimitSavana').val(m.drynessLimitSavana);

				$('#elWaterLevel').html('el. 0 - '+m.waterLevel);
				$('#elSwampLevel').html('el. '+m.waterLevel+' - '+m.firstElevationBlock);
				$('#moSwampLevel').html('dr. 0 - '+m.drynessLimitBeach);
				$('#elBeachLevel').html('el. '+m.waterLevel+' - '+m.firstElevationBlock);
				$('#moBeachLevel').html('dr. '+m.drynessLimitBeach+' - 0');
				$('#elBrushLevel').html('el. '+m.firstElevationBlock+' - '+m.secondElevationBlock);
				$('#moBrushLevel').html('dr. 0 - '+m.drynessLimitBrush);
				$('#elGrassLevel').html('el. '+m.firstElevationBlock+' - '+m.secondElevationBlock);
				$('#moGrassLevel').html('dr. '+m.drynessLimitBrush+' - '+m.drynessLimitGrass);
				$('#elSavanaLevel').html('el. '+m.firstElevationBlock+' - '+m.secondElevationBlock);
				$('#moSavanaLevel').html('dr. 0.5 - '+m.drynessLimitSavana);
				$('#elDesertLevel').html('el. 0 -'+m.thirdElevationBlock);
				$('#moDesertLevel').html('dr. '+m.drynessLimitSavana+' - 1');
				$('#elStoneLevel').html('el. '+m.secondElevationBlock+' - '+m.thirdElevationBlock);
				$('#moStoneLevel').html('dr. 0 - '+m.drynessLimitSavana);
				$('#elSandstoneLevel').html('el. '+m.secondElevationBlock+' - '+m.thirdElevationBlock);
				$('#moSandstoneLevel').html('dr. '+m.drynessLimitSavana+' - 1');
				$('#elSnowLevel').html('el. '+m.thirdElevationBlock+' - 1');
<?php
			forEach($layers as $layer){
				echo "\t\t\t\t$('#".$layer."OffsetValue').val(".$layer."Obj.offset);\n";
				echo "\t\t\t\t$('#".$layer."FrequencyValue').val(".$layer."Obj.frequency);\n";
				echo "\t\t\t\t$('#".$layer."OctaveValue').val(".$layer."Obj.octave);\n";
				echo "\t\t\t\t$('#".$layer."RedistributionValue').val(".$layer."Obj.redistribution);\n";
			}
		?>
			}
			function redrawMap(){
				setNoiseValue();
				m.make(w,h);
				m.show();
			}
		</script>
	<style>
		body{}
		input:focus{
			outline: none;
		}
		h5{
			margin: 0;
		}
		canvas{
			position: fixed;
			left: 5px;
			top: 5px;
			z-index: -1;
			/*margin: 5px auto;*/
		}
		#config{
		    width: 230px;
			padding-top: 5px;
			padding-left: 5px;
			/*margin-left: -230px;*/
			margin-left: 0;
			
		}
		.center{
			text-align: center;
		}
		table{
			width: 100%;
			background: #4d4d4d;
			color: #00ff00;
		}
		table tr td{
			padding: 5px;
		}
		#redrawMap,
		#newSeed{
			background-color: #4d4d4d;
			border: 0px;
			font-size: 110%;
			width: 100%;
			text-align: center;
		}
		.slider-handle {
			background-color: #19a500;
			background-image: -webkit-linear-gradient(top,#19a500 0,#a4d806 100%);
			background-image: -o-linear-gradient(top,#19a500 0,#a4d806 100%);
			background-image: linear-gradient(to bottom,#19a500 0,rgb(164, 216, 6) 100%);
		}
		div.tooltip{
			display: none!important;
		}
		.noiseValue{
			width: 100%;
			background: #4d4d4d;
			color: #00ff00;
			border: 0px;
		}
		.layerName{
			font-size: 130%;
			cursor: pointer;
		}
		.separator{
			border-top: solid 2px #ffffff;
		}
		.layerBlock,
		.infoBlock,
		.baseBlock,
		.levelBlock{
			display: none;
		}
	</style>
	</head>
	<body>
	<div id="config">
		<table border = 1>
			<tr><td colspan="2"><input id="redrawMap" type="button" value="Redraw Map"></td></tr>
			<tr><td id="baseTitle" colspan="2" class="center layerName separator"><b>Base Info</b></td></tr>
			<tr class="baseBlock"><td><input id="newSeed" type="button" value="new Seed"/></td><td  id="seed" class="center"></td></tr>
			<tr class="baseBlock"><td><h5>Width</h5></td><td><input class="noiseValue" type="number" step="1" min="1" max="2000" id="w"></td>
			<tr class="baseBlock"><td><h5>Height</h5></td><td><input class="noiseValue" type="number" step="1" min="1" max="2000" id="h"></td>
			<tr class="baseBlock"><td><h5>Block size</h5></td><td><input class="noiseValue" type="number" step="1" min="1" max="50" id="scl"></td>
			</tr>
			<?php
				forEach($layers as $layer){
					echo '<tr><td id="'.$layer.'Title" colspan="2" class="center layerName separator"><b>'.ucfirst($layer).'</b></td></tr>';
					echo '<tr class="'.$layer.'Block layerBlock"><td><h5>offset</h5></td><td><input class="noiseValue" type="number" step="0.01" min="0" max="2" id="'.$layer.'OffsetValue"></td></tr>';
					echo '<tr class="'.$layer.'Block layerBlock"><td><h5>frequency</h5></td><td><input class="noiseValue" type="number" step="0.1" min="0" max="10" id="'.$layer.'FrequencyValue"></td></tr>';
					echo '<tr class="'.$layer.'Block layerBlock"><td><h5>octave</h5></td><td><input class="noiseValue" type="number" step="1" min="0" max="32" id="'.$layer.'OctaveValue"></td></tr>';
					echo '<tr class="'.$layer.'Block layerBlock"><td><h5>redistribution</h5></td><td><input class="noiseValue" type="number" step="0.01" min="0" max="10" id="'.$layer.'RedistributionValue"></td></tr>';
					switch($layer){
						case 'forest':
							echo '<tr class="'.$layer.'Block layerBlock"><td><h5>% in Brush</h5></td><td><input class="noiseValue" type="number" step="0.01" min="0" max="1" id="'.$layer.'InBrush"></td></tr>';
							echo '<tr class="'.$layer.'Block layerBlock"><td><h5>% in Grass</h5></td><td><input class="noiseValue" type="number" step="0.01" min="0" max="1" id="'.$layer.'InGrass"></td></tr>';
							echo '<tr class="'.$layer.'Block layerBlock"><td><h5>% in Savana</h5></td><td><input class="noiseValue" type="number" step="0.01" min="0" max="1" id="'.$layer.'InSavana"></td></tr>';
							break;
					}
				}
			?>
			<tr><td id="levelTitle" colspan="2" class="center layerName separator"><b>Block Level</b></td></tr>
			<tr class="levelBlock"><td><h5>water level</h5></td><td><input class="noiseValue" type="number" step="0.01" min="0" max="1" id="waterLevel"></td></tr>
			<tr class="levelBlock"><td><h5>1° el. block</h5></td><td><input class="noiseValue" type="number" step="0.01" min="0" max="1" id="firstElevationBlock"></td></tr>
			<tr class="levelBlock"><td><h5>dr. limit Beach</h5></td><td><input class="noiseValue" type="number" step="0.01" min="0" max="1" id="drynessLimitBeach"></td></tr>
			<tr class="levelBlock"><td><h5>2° el. block</h5></td><td><input class="noiseValue" type="number" step="0.01" min="0" max="1" id="secondElevationBlock"></td></tr>
			<tr class="levelBlock"><td><h5>dr. limit Grass</h5></td><td><input class="noiseValue" type="number" step="0.01" min="0" max="1" id="drynessLimitGrass"></td></tr>
			<tr class="levelBlock"><td><h5>dr. limit Brush</h5></td><td><input class="noiseValue" type="number" step="0.01" min="0" max="1" id="drynessLimitBrush"></td></tr>
			<tr class="levelBlock"><td><h5>dr. limit Savana</h5></td><td><input class="noiseValue" type="number" step="0.01" min="0" max="1" id="drynessLimitSavana"></td></tr>
			<tr class="levelBlock"><td><h5>3° el. block</h5></td><td><input class="noiseValue" type="number" step="0.01" min="0" max="1" id="thirdElevationBlock"></td></tr>
			
			
			

			<tr><td id="infoTitle" colspan="2" class="center layerName separator"><b>Biome Info</b></td></tr>
					
			<tr class="infoBlock separator"><td>Water</td><td  class="separator" title="elevation level" id="elWaterLevel"></td></tr>
			<tr class="infoBlock"><td rowspan='2'>Swamp</td><td title="elevation level" id="elSwampLevel"></td></tr>
			<tr class="infoBlock"><td title="dryness level" id="moSwampLevel"></td></tr>
			<tr class="infoBlock"><td rowspan='2'>Beach</td><td title="elevation level" id="elBeachLevel"></td></tr>
			<tr class="infoBlock"><td title="dryness level" id="moBeachLevel"></td></tr>
			<tr class="infoBlock"><td rowspan='2'>Brush</td><td title="elevation level" id="elBrushLevel"></td></tr>
			<tr class="infoBlock"><td title="dryness level" id="moBrushLevel"></td></tr>
			<tr class="infoBlock"><td rowspan='2'>Grass</td><td title="elevation level" id="elGrassLevel"></td></tr>
			<tr class="infoBlock"><td title="dryness level" id="moGrassLevel"></td></tr>
			<tr class="infoBlock"><td rowspan='2'>Savana</td><td title="elevation level" id="elSavanaLevel"></td></tr>
			<tr class="infoBlock"><td title="dryness level" id="moSavanaLevel"></td></tr>
			<tr class="infoBlock"><td rowspan='2'>Desert</td><td title="elevation level" id="elDesertLevel"></td></tr>
			<tr class="infoBlock"><td title="dryness level" id="moDesertLevel"></td></tr>
			<tr class="infoBlock"><td rowspan='2'>Stone</td><td title="elevation level" id="elStoneLevel"></td></tr>
			<tr class="infoBlock"><td title="dryness level" id="moStoneLevel"></td></tr>
			<tr class="infoBlock"><td rowspan='2'>Sandstone</td><td title="elevation level" id="elSandstoneLevel"></td></tr>
			<tr class="infoBlock"><td title="dryness level" id="moSandstoneLevel"></td></tr>
			<tr class="infoBlock"><td rowspan='2'>Snow</td><td title="elevation level" id="elSnowLevel"></td></tr>
		</table>
	</div>
	<script>
		$('#newSeed').click(function(){
			m.seed = Math.floor(Math.random()*100000000000000);
			
			setNoiseValue();
			redrawMap();
		});
		$('#redrawMap').click(function(){
			redrawMap();
		});
		$('#infoTitle').click(function(){
			if(infoShow)$('.infoBlock').hide();
			else $('.infoBlock').show();
			infoShow = !infoShow;
		});
		$('#levelTitle').click(function(){
			if(levelShow)$('.levelBlock').hide();
			else $('.levelBlock').show();
			levelShow = !levelShow;
		});
		$('#baseTitle').click(function(){
			if(baseShow)$('.baseBlock').hide();
			else $('.baseBlock').show();
			baseShow = !baseShow;
		});
		/**/
		$("#config").mouseenter(function(event){
			if(!menuIsMoving){
				menuIsMoving=true;
				$(this).animate({'margin-left' : '0'},'fast',function(){menuIsMoving=false;});
			}
		})
		$("#config").mouseleave(function(event){
			if(!menuIsMoving){
				menuIsMoving=true;
				$(this).animate({'margin-left' : '-200px'},'fast',function(){menuIsMoving=false;});
			}
		});
		/**
		$("#config").hover(function(event){
			if(!menuIsMoving){
				menuIsMoving=true;
				$("#config").animate({'margin-left' : '0'},function(){menuIsMoving=false;});
			}
		},function(event){
			if(!menuIsMoving){
				menuIsMoving=true;
				$("#config").animate({'margin-left' : '-200px'},function(){menuIsMoving=false;});
			}
		});
		/**/
		$('#waterLevel').change(function(event){
			m.waterLevel = parseFloat(event.target.value);
			redrawMap();
		});

		$('#firstElevationBlock').change(function(event){
			m.firstElevationBlock = parseFloat(event.target.value);
			redrawMap();
		});
		$('#secondElevationBlock').change(function(event){
			m.secondElevationBlock = parseFloat(event.target.value);
			redrawMap();
		});
		$('#thirdElevationBlock').change(function(event){
			m.thirdElevationBlock = parseFloat(event.target.value);
			redrawMap();
		});
		
		$('#drynessLimitBeach').change(function(event){
			m.drynessLimitBeach = parseFloat(event.target.value);
			console.log(m.drynessLimitBeach);
			redrawMap();
		});
		$('#drynessLimitGrass').change(function(event){
			m.drynessLimitGrass = parseFloat(event.target.value);
			redrawMap();
		});
		$('#drynessLimitBrush').change(function(event){
			m.drynessLimitBrush = parseFloat(event.target.value);
			redrawMap();
		});
		$('#drynessLimitSavana').change(function(event){
			m.drynessLimitSavana = parseFloat(event.target.value);
			redrawMap();
		});

		$('#scl').change(function(event){
			scl = parseInt(event.target.value);
			redrawMap();
		});
		$('#w').change(function(event){
			w = parseInt(event.target.value);
			redrawMap();
		});
		$('#h').change(function(event){
			h = parseInt(event.target.value);
			redrawMap();
		});
		
		$('#forestInBrush').change(function(event){
			m.forestInBrush = parseFloat(event.target.value);
			redrawMap();
		});
		$('#forestInGrass').change(function(event){
			m.forestInGrass = parseFloat(event.target.value);
			redrawMap();
		});
		$('#forestInSavana').change(function(event){
			m.forestInSavana = parseFloat(event.target.value);
			redrawMap();
		});
		
		<?php
			forEach($layers as $layer){
				echo "\t\t$('#".$layer."OffsetValue').change(function(event){";
				echo $layer."Obj.offset = event.target.value;redrawMap();});\n";
				echo "\t\t$('#".$layer."FrequencyValue').change(function(event){";
				echo $layer."Obj.frequency = event.target.value;redrawMap();});\n";
				echo "\t\t$('#".$layer."RedistributionValue').change(function(event){";
				echo $layer."Obj.redistribution = event.target.value;redrawMap();});\n";
				echo "\t\t$('#".$layer."OctaveValue').change(function(event){";
				echo $layer."Obj.octave = event.target.value;redrawMap();});\n";
				echo "\t\t$('#".$layer."Title').click(function(){";
				echo "if(".$layer."Show) $('.".$layer."Block').hide(); else $('.".$layer."Block').show(); ";
				echo $layer."Show = !".$layer."Show;});\n";
			}
		?>
	</script>
	<script src="sketch.js" type="text/javascript"></script>
	</body>
</html>
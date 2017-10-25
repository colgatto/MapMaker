class Map{

	constructor(seed){
		this.seed = seed;
		this.type = 'Normal';
		this.noiseSet = {};
		
		this.waterLevel = 0.27;
		
		this.forestInBrush = 0.24;
		this.forestInGrass = 0.20;
		this.forestInSavana = 0.17;
		
		this.drynessLimitBeach = 0.6;
		
		this.drynessLimitGrass = 0.3;
		this.drynessLimitBrush = 0.5;
		this.drynessLimitSavana = 0.7;
		
		this.firstElevationBlock = 0.35;
		this.secondElevationBlock = 0.6;
		this.thirdElevationBlock = 0.75;
	}
	
	make(w,h){
		this.w = w;
		this.h = h;
		this.startX = 0;
		this.startY = 0;
		this.noiseSet.elevation = this.newNoiseMap(this.seed,elevationObj);
		this.noiseSet.dryness = this.newNoiseMap(-this.seed,drynessObj);
		this.noiseSet.forest = this.newNoiseMap(this.seed*2,forestObj);
		this.noiseSet.color = this.newNoiseMap(this.seed+70,colorObj);
		this.tiles = [];
		for(var i = 0; i < this.w; i++){
			this.tiles[i] = [];
			for(var j = 0; j < this.h; j++){
				this.tiles[i][j] = this.makeBlock(i,j); 
			}
		}
	}
	
	newNoiseMap(seed,data){
		return new noiseMap(this.startX, this.startY, this.w, this.h, seed, data);
	}
	
	show(){
		fill(255);
		rect(0,0,canvasWidth,canvasHeight);
		var widthOffset = width/2-(this.w * scl)/2;
		for(var i=widthOffset, ww = this.w * scl + widthOffset, tx=0; i < ww; i += scl, tx++){
			for(var j=0, hh = this.h * scl, ty=0; j < hh; j += scl, ty++){
				/**/
				fill(this.tiles[tx][ty].color);
				rect(i, j, scl, scl);
				/**
				console.log(this.tiles[tx][ty].name);
				image(imageSet[this.tiles[tx][ty].name], i, j, scl, scl);
				/**/
			}
		}
		console.log(scl);
	}

	makeBlock(i,j){
		var elevation = this.noiseSet.elevation.set[i][j];
		var dryness = this.noiseSet.dryness.set[i][j];
		var color = this.noiseSet.color.set[i][j];
		var forest = this.noiseSet.forest.set[i][j];
		
		if(dryness >= this.drynessLimitSavana && elevation < this.secondElevationBlock)
			return new Desert(elevation,i,j);
		
		if(elevation < this.waterLevel)
			return new Water(elevation,i,j);
		if(elevation < this.firstElevationBlock)
			return dryness>this.drynessLimitBeach ? new Beach(elevation,i,j) : new Swamp(elevation,i,j);
		if(elevation < this.secondElevationBlock){
			if(dryness < this.drynessLimitBrush)
				return forest<this.forestInBrush ? new Forest(elevation,i,j,'ForestBrush') : new Brush(elevation,i,j);
			if(dryness < this.drynessLimitGrass)
				return forest<this.forestInGrass ? new Forest(elevation,i,j,'ForestGrass') : new Grass(elevation,i,j);
			if(dryness < this.drynessLimitSavana)
				return forest<this.forestInSavana ? new Forest(elevation,i,j,'ForestSavana') : new Savana(elevation,i,j);
		}
		if(elevation < this.thirdElevationBlock){
			if(dryness < this.drynessLimitSavana)
				return new Stone(elevation,i,j);
			else
				return new Sandstone(elevation,i,j);
		}
		
		return new Snow(elevation,i,j);
	}
}

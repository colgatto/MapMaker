class noiseMap{
	
	constructor(x,y,w,h,seed,data){
		this.x = x;
		this.y = y;
		this.w = w;
		this.h = h;
		this.seed = seed;
		this.offset = parseFloat(data.offset);
		this.frequency = parseFloat(data.frequency);
		this.octave = parseInt(data.octave);
		this.redistribution = parseFloat(data.redistribution);
		this.make();
	}
	
	makeInitI(){
		return this.seed + this.x * this.w * this.offset; 
	}
	makeInitJ(){
		return this.seed + this.y * this.h * this.offset; 
	}
	make(){
		this.set = [];
		var ni = this.makeInitI();
		for(var i = 0; i < this.w; i++, ni+=this.offset){
			this.set[i] = [];
			var nj = this.makeInitJ();
			for(var j = 0; j < this.h; j++, nj+=this.offset){
				this.set[i][j] = this.noiseFromOctave(ni,nj);
			}
		}
	}
	noiseFromOctave(x,y){
		var finalNoise = 0;
		for(var i=0, octDown=1, octUp=this.frequency;i<this.octave;i++,octDown/=2,octUp*=2)
			finalNoise+=octDown * noise(octUp * x, octUp * y);
		return pow(finalNoise,this.redistribution);
	}
}
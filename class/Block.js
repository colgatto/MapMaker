/* generic abstract Block */
class Block{
	
	constructor(noise,x,y){
		this.x = x;
		this.y = y;
		this.noise = noise;
		this.color = color(this.noise*255);
		this.isMinable = false;
		this.isLiquid = false;
		this.isPassable = false;
		this.isOccuped = false;
		this.content = {};
		this.size = 0;
		this.hit = 0;
		this.resistance = 999999999;
	}
	
	makeContent(){}
	
	mine(){
		if(++this.hit>this.resistance){
			this.hit = 0;
			if(this.size>0){
				var r = random(1,this.size);
				var allSum = 0;
				for(var item in this.content){
					if (r<=this.content[item]+allSum){
						this.content[item]--;
						if(--this.size===0){
							this.color -= color(90);
							this.isPassable = true;
							this.show();
						}
						//console.log(item + ' - ' + this.content[item]);
						return { 
							name : item,
							value : 1
						};
						break;
					}else{
						allSum+=this.content[item];
					}
				}
			}else
				return false;
		}else
			return 'hit';
	}
	
	sum(value){
		this.size+=value;
		return value;
	}
	
	show(){
		fill(this.color);
		rect(this.x*scl, this.y*scl, scl, scl);
	}

}
/* all Blocks */
class Water extends Block{
	constructor(noise,x,y){
		super(noise,x,y);
		this.name = 'Water';
		this.color = color(0,53,(this.noise-0.055)*1000);
		this.isLiquid = true;
		this.makeContent();
	}
	makeContent(){
		this.content.water = this.sum(Math.floor(random(180,210)-this.noise));
	}
}
class Beach extends Block{
	constructor(noise,x,y){
		super(noise,x,y);
		this.name = 'Beach';
		this.color = color(220+this.noise*100,200+this.noise*100,91);
		this.isMinable = true;
		this.isPassable = true;
		this.resistance = 10;
		this.makeContent();
	}
	makeContent(){
		this.content.sand = this.sum(Math.floor(random(180,210)-this.noise));
	}
}
class Swamp extends Block{
	constructor(noise,x,y){
		super(noise,x,y);
		this.name = 'Swamp';
		this.color = color(11,100+this.noise*100,46);
		this.isMinable = true;
		this.isPassable = true;
		this.resistance = 10;
		this.makeContent();
	}
	makeContent(){
		this.content.sand = this.sum(Math.floor(random(150,200)-this.noise));
	}
}
class Tundra extends Block{
	constructor(noise,x,y){
		super(noise,x,y);
		this.name = 'Tundra';
		this.color = color(11,117,46);
		this.isMinable = true;
		this.isPassable = true;
		this.resistance = 10;
		this.makeContent();
	}
	makeContent(){
		this.content.dirty = this.sum(Math.floor(random(400,600)));
	}
}
class Brush extends Block{
	constructor(noise,x,y){
		super(noise,x,y);
		this.name = 'Brush';
		this.color = color(43,100+this.noise*100,13);
		this.isMinable = true;
		this.isPassable = true;
		this.resistance = 10;
		this.makeContent();
	}
	makeContent(){
		this.content.dirty = this.sum(Math.floor(random(400,600)));
	}
}
class Forest extends Block{
	constructor(noise,x,y,name){
		super(noise,x,y);
		this.name = name;
		this.color = color(125,63,0);
		this.isMinable = true;
		this.resistance = 16;
		this.makeContent();
	}
	makeContent(){
		this.content.wood = this.sum(Math.floor(random(400,600)));
	}
}
class Grass extends Block{
	constructor(noise,x,y){
		super(noise,x,y);
		this.name = 'Grass';
		this.color = color(61-this.noise*10,100+this.noise*100,22);
		this.isMinable = true;
		this.isPassable = true;
		this.resistance = 10;
		this.makeContent();
	}
	makeContent(){
		this.content.dirty = this.sum(Math.floor(random(200,300)));
	}
}
class Savana extends Block{
	constructor(noise,x,y){
		super(noise,x,y);
		this.name = 'Savana';
		this.color = color(80+this.noise*90,122+this.noise*90,17);
		this.isMinable = true;
		this.isPassable = true;
		this.resistance = 10;
		this.makeContent();
	}
	makeContent(){
		this.content.dirty = this.sum(Math.floor(random(200,300)));
		this.content.sand = this.sum(Math.floor(random(200,300)));
	}
}
class Desert extends Block{
	constructor(noise,x,y){
		super(noise,x,y);
		this.name = 'Desert';
		this.color = color(210+this.noise*100,120+this.noise*100,91);
		this.isMinable = true;
		this.isPassable = true;
		this.resistance = 10;
		this.makeContent();
	}
	makeContent(){
		this.content.sand = this.sum(Math.floor(random(400,600)));
	}
}
class Stone extends Block{
	constructor(noise,x,y){
		super(noise,x,y);
		this.name = 'Stone';
		this.color = color(210-this.noise*200);
		this.isMinable = true;
		this.resistance = 20;
		this.makeContent();
	}
	makeContent(){
		//this.content.stone = this.sum(Math.floor(random(20,50)+this.noise*2));
		this.content.stone = this.sum(Math.floor(random(10,20)));
		//this.content.iron = this.sum(Math.floor(random(1,5)));
	}
}
class Sandstone extends Block{
	constructor(noise,x,y){
		super(noise,x,y);
		this.name = 'Sandstone';
		this.color = color(200,164,109);
		this.isMinable = true;
		this.resistance = 20;
		this.makeContent();
	}
	makeContent(){
		//this.content.stone = this.sum(Math.floor(random(20,50)+this.noise*2));
		this.content.stone = this.sum(Math.floor(random(10,20)));
		//this.content.iron = this.sum(Math.floor(random(1,5)));
	}
}
class Iron extends Block{
	constructor(noise,x,y){
		super(noise,x,y);
		this.name = 'Iron';
		this.color = color(151,148,85);
		this.isMinable = true;
		this.resistance = 30;
		this.makeContent();
	}
	makeContent(){
		this.content.iron = this.sum(Math.floor(random(0,100)));
	}
}
class Coal extends Block{
	constructor(noise,x,y){
		super(noise,x,y);
		this.name = 'Coal';
		this.color = color((this.noise-0.2)*100);
		this.isMinable = true;
		this.resistance = 25;
		this.makeContent();
	}
	makeContent(){
		this.content.coal = this.sum(Math.floor(random(10,60)));
	}
}
class Snow extends Block{
	constructor(noise,x,y){
		super(noise,x,y);
		this.name = 'Snow';
		this.color = color(230);
		this.isMinable = true;
		this.resistance = 10;
		this.makeContent();
	}
	makeContent(){
		this.content.snow = this.sum(Math.floor(random(50,100)+this.noise));
	}
}
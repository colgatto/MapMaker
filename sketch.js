
var canvasWidth = window.innerWidth-10;
var canvasHeight = window.innerHeight-10;

var scl = 10;
var w = 130;
var h = 65;

var elevationObj = {
			offset: 0.1,
			frequency: 1,
			octave: 1,
			redistribution: 1
		};
var drynessObj = {
			offset: 0.03,
			frequency: 0.7,
			octave: 1,
			redistribution: 1
		};
var forestObj = {
			offset: 0.6,
			frequency: 1,
			octave: 1,
			redistribution: 1
		};
var colorObj = {
			seed: this.seed+70,
			offset: 0.1,
			frequency: 1,
			octave: 1,
			redistribution: 1
		};
		
var imageSet = [];
function preload(){
	/*
	imageSet['Stone'] = loadImage('tile-stone.png');
	imageSet['Beach'] = loadImage('tile-beach.png');
	imageSet['Sandstone'] = loadImage('tile-sandstone.png');
	imageSet['Brush'] = loadImage('tile-brush.png');
	imageSet['Grass'] = loadImage('tile-grass.png');
	imageSet['Desert'] = loadImage('tile-desert.png');
	imageSet['Swamp'] = loadImage('tile-swamp.png');
	imageSet['Water'] = loadImage('tile-water.png');
	imageSet['Snow'] = loadImage('tile-snow.png');
	imageSet['Savana'] = loadImage('tile-savana.png');
	imageSet['ForestBrush'] = loadImage('tile-brush-forest.png');
	imageSet['ForestGrass'] = loadImage('tile-grass-forest.png');
	imageSet['ForestSavana'] = loadImage('tile-savana-forest.png');
	*/
}
function setup() {
	createCanvas(canvasWidth, canvasHeight);
	background(51);
	noStroke();
	noLoop();
	m = new Map(Math.floor(Math.random()*100000000000000));
	m.make(w,h);
	m.show();
	setNoiseValue();
}

function draw() {
}

function plugin0( )
{
	
	return document.getElementById(ourId);
}


plugin = plugin0;
var Index;
var Sig;
//var LCDMode;
//var LCDDest;
//var LCDXPos;
//var LCDYPos;
//var img = new Image();
var ourId;



function initSigPlusWebPlugin(pluginId)
{
	ourId = pluginId;
}


function Enable()
{
	plugin().displayPenWidth = 20;
	plugin().antiAliasSpotSize = 2.5;
	//			plugin().antiAliasLineScale = 1.0;
	plugin().tabletState = 1;
	plugin().captureMode = 2;
	Index = setInterval(Refresh, 50);
}


function Disable()
{
	plugin().tabletState = 0;
	clearInterval(Index);
}


function Refresh()
{
	plugin().refreshEvent();
}

function KeyPad()
{
	plugin().KeyPadQueryHotSpot(0);
}

function clearSignature()
{
	plugin().clearSignature();
}

function clearHotSpotPoints()
{
	plugin().clearHotSpotPoints();
}


function newTopazImage( Dest, Mode, X, Y, Img)
	{
	var img = new Image();

	img.LCDDest = Dest;
	img.LCDMode = Mode;
	img.LCDXPos = X;
	img.LCDYPos = Y;
	img.hand = -1;

	img.send = function ()
	{
		if (this.hand >= 0)
		{
			plugin().lcdSendGraphic(this.LCDDest, this.LCDMode, this.hand);
			plugin().captureMode = 2;
		}
	};

	img.onload = function ()
	{
		var c = document.createElement( 'canvas' );
		var ctx = c.getContext('2d');
		var sVal = "";
		c.width = this.width;
		c.height = this.height;
		ctx.drawImage(this, 0, 0);
		//		this.hand = createLcdBitmapFromCanvas(c, 0, 0, 10, 10);
		this.hand = createLcdBitmapFromCanvas(c, this.LCDXPos, this.LCDYPos, this.width, this.height);
		//		plugin().lcdSendGraphic(this.Dest, this.Mode, hand);
		//		plugin().deleteLCDBitmap(hand);
		//		plugin().captureMode = 2;
	};

	img.src = Img;
	return img;
	}





function createLcdBitmapFromCanvas(OurCanvas, XPos, YPos, width, height)
{
	var CanvasCtx = OurCanvas.getContext('2d');
	var hnd = plugin().createLCDBitmap(XPos, YPos, width, height, 1, 50);
	var ImgData = CanvasCtx.getImageData(0, 0, width, height);
	var j = 0;
	var sVal = "";
	for (var y = 0; y < height; y++)
		for (var x = 0; x < width; x++)
		{
			sVal += ToHexString(ImgData.data[j]);
			sVal += ToHexString(ImgData.data[j + 1]);
			sVal += ToHexString(ImgData.data[j + 2]);
			sVal += ToHexString(ImgData.data[j + 3]);
			j = j + 4;
		}

	plugin().lcdFillBitmap(hnd, sVal);
	return hnd;
}


function toHex(NibVal)
{
	switch (NibVal)
	{
		case 0:
			return "0";
		case 1:
			return "1";
		case 2:
			return "2";
		case 3:
			return "3";
		case 4:
			return "4";
		case 5:
			return "5";
		case 6:
			return "6";
		case 7:
			return "7";
		case 8:
			return "8";
		case 9:
			return "9";
		case 10:
			return "A";
		case 11:
			return "B";
		case 12:
			return "C";
		case 13:
			return "D";
		case 14:
			return "E";
		case 15:
			return "F";
	}
}

function ToHexString(ByteVal)
{
	var Str = "";
	Str += toHex((ByteVal >> 4) & 0x0f);
	Str += toHex(ByteVal & 0x0F);
	return Str
}



//function createLCDBitmapFromImage(Dest, Mode, X, Y, Img)
//{
//	LCDDest = Dest;
//	LCDMode = Mode;
//	LCDXPos = X;
//	LCDYPos = Y;
//
//	img.src = Img;
//}


function textToTablet(x, y, height, str, fnt)
{
	var c = document.createElement('canvas');
	var ctx = c.getContext('2d');
	ctx.font = fnt;
	var txt = str;
	var xs = ctx.measureText(txt).width;
	var ys = height;
	c.width = xs;
	c.height = ys;

	ctx.font = fnt;
	ctx.fillStyle = '#FFFFFF'
	ctx.rect(0, 0, xs, ys);
	ctx.fill();


	ctx.fillStyle = '#000000'
	ctx.textBaseline = "top";
 	ctx.fillText(txt, 0, 0);

	var hand = createLcdBitmapFromCanvas(c, x, y, xs, ys);
	plugin().lcdSendGraphic(0, 2, hand);
	plugin().deleteLCDBitmap(hand);
}





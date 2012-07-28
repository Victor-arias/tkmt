/*
 * jEye jQuery plugin
 *
 * Copyright (c) 2009 Giovanni Casassa (senamion.com - senamion.it)
 *
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://www.senamion.com
 *
 */

jQuery.fn.jEye = function(o) {

	o = jQuery.extend({
		xEye: 0,
		yEye: 0,
		wEye: 38,
		hEye: 38,
		wPupil: 14,
		hPupil: 14,
		eyes: 1
	}, o);

	return this.each(function(i) {
		var el = $(this);
		var xPupil = Math.floor((o.wEye - o.wPupil) / 2);
		var yPupil = Math.floor((o.hEye - o.hPupil) / 2);
		var radius = Math.floor((o.wEye - o.wPupil) / 2) - 1;
		var	position = el.position();
		var xEl = position.left;
		var yEl = position.top;

		el.prepend("<div id='ojo'"/*id='occhio" + i + "'*/+" style='/*position: absolute; */background: transparent url(/images/occhio.png) center center no-repeat; /*top: " + o.yEye + "px; left: " + o.xEye + "px; */width: " + o.wEye + "px; height: " + o.hEye + "px;' >" +
			"<img id='pupilla" + i + "' src='/images/pupilla.png' style='position: relative; top:" + yPupil + "px; left:" + xPupil + "px; width: " + o.wPupil + "px; height:" + o.hPupil + "px' />" + 
			"</div>");
		if (o.eyes == 2) {
			el.append("<div id='occhiob" + i + "' style='position: absolute; background: transparent url(/images/occhio.png) center center no-repeat; top: " + o.yEye + "px; left: " + (o.xEye+o.wEye) + "px; width: " + o.wEye + "px; height: " + o.hEye + "px;' >" +
				"<img id='pupillab" + i + "' src='/images/pupilla.png' style='position: relative; top:" + yPupil + "px; left:" + xPupil + "px; width: " + o.wPupil + "px; height:" + o.hPupil + "px' />" + 
				"</div>");
			}

		el.mousemove(function(kmouse){
			var r = 5;
			var ym = kmouse.pageY - yEl;
			var xm = kmouse.pageX - xEl;
			var xo = o.xEye + 19;
			var yo = o.yEye + 19;
			ang = Math.atan((yo - ym) / (xm - xo));
			if (xo > xm)
				ang += Math.PI;
			$('#pupilla'+i).css("top", (radius - Math.floor(Math.sin(ang) * r))+"px").css("left", (Math.floor(Math.cos(ang) * r) + radius) + "px");
			
			if (o.eyes == 2) {
				xm -= o.wEye;
				ang = Math.atan((yo - ym) / (xm - xo));
				if (xo > xm)
					ang += Math.PI;
				$('#pupillab'+i).css("top", (radius - Math.floor(Math.sin(ang) * r))+"px").css("left", (Math.floor(Math.cos(ang) * r) + radius) + "px");
				}
		});
	});
};
var ExtensionsMaps = { Version : { Major:1, Minor:2, Revision:0 } };

//Map Size
var aMapSize = [3, 2, 1]; //Width,Height,Zoom;
//Width,Height: 0=12, 1=24, 2=36, 3=48, 4=60, 5=72
//Zoom: 0=50%, 1=100%, 2=200%

//List of Extensions
var aExtensions = ["DT1", "DT2", "DT3", "DT4"];

//DO NOT CHANGE THE FOLLOWING SECTION OF CODE
//Includes Extensions
if (online && -1 < document.URL.indexOf("?")) aExtensions = document.URL.split("?")[1].split(",");
for (var i = 0; i < aExtensions.length; i++) {
	/*
	var tStuff = "./tiles/" + aExtensions[i];
	document.write('<script type="text/javascript" src="./tiles/' + aExtensions[i] + '/Manifest.js"></script>');
	alert(tStuff);
	*/
	var fileref=document.createElement('script')
	fileref.setAttribute("type","text/javascript")
	fileref.setAttribute("src", './tiles/' + aExtensions[i] + '/Manifest.js')
	document.getElementsByTagName("head")[0].appendChild(fileref);
}
//DO NOT CHANGE THE PREVIOUS SECTION OF CODE

//DO NOT CHANGE THIS FUNCTION NAME
function offlineOnLoad() {
	//Sets whether or not to allow free form building (false uses your Set Count settings; true uses unlimited tiles)
	SetFreeForm(false);
	//Sets whether or not the icons in the Tiles Tab have description text (false means no text; true means text)
	SetMapIconText(true);
	SetTilesIconText(false);
	//True deletes all Tiles in a group when the base is deleted. False detaches all the files attached to the base.
	SetGroupDeleteOption(true);
	
	//Sets the default number of each TileSet. Saved values in the cookie override these values. NOTE: Cookies only work online
	SetCount("DT1", 1);
	SetCount("DT2", 1);
	SetCount("DT3", 1);
	SetCount("DT4", 1);

	//Adds maps to the Maps drop down
	AddMap("DT1 - Sample Dungeon 1,0.22.B.270.224.80.5,0.22.B.0.128.64.6,0.22.B.0.128.96.7,0.19.B.0.208.208.8,0.16.B.0.336.208.9,0.0.A.90.64.224.10,0.0.A.90.64.320.11,0.6.A.180.32.224.12,0.6.A.90.32.320.13,0.11.B.0.80.224.14,0.18.A.0.80.288.15,0.9.B.0.144.256.16,0.7.A.0.128.80.17,0.1.A.90.272.272.18,0.13.B.0.240.176.19,0.12.B.0.400.176.20,0.5.A.0.272.224.21,0.17.A.0.288.128.22,0.17.A.180.352.128.23,0.15.A.0.384.96.24,0.14.A.90.416.32.25,0.2.B.0.128.128.26,0.8.B.0.352.96.27,0.3.B.90.96.32.28,0.10.B.0.272.144.29,0.14.B.0.256.96.30,0.22.B.0.128.32.31,0.22.B.180.192.96.32,0.22.B.0.336.176.33,0.22.B.0.336.144.34");
	AddMap("DT1 - Sample Dungeon 2,0.1.B.0.288.112.5,0.1.B.0.288.112.6,0.3.B.180.96.32.7,0.17.A.0.144.128.8,0.17.A.90.272.208.9,0.22.B.90.144.64.10,0.19.B.0.144.144.11,0.4.A.90.128.176.12,0.22.A.90.144.208.13,0.22.A.0.208.240.14,0.13.A.0.224.160.15,0.4.A.90.272.272.16,0.9.B.0.288.272.17,0.12.A.0.304.288.18,0.22.B.90.144.304.19,0.15.A.0.176.336.20,0.8.B.0.96.80.21,0.6.B.0.192.80.22,0.16.B.90.352.112.23,0.22.A.0.336.176.24,0.10.A.0.432.160.25,0.0.B.0.416.144.26,0.0.B.90.416.208.27,0.22.A.0.336.144.28,0.17.A.180.96.64.29,0.17.A.180.192.64.30,0.22.B.0.64.160.31,0.22.B.90.96.192.32,0.14.B.90.64.192.33,0.2.A.90.80.176.34,0.6.B.0.32.240.35,0.20.A.0.32.256.36");
	AddMap("DT1 - Sample Dungeon 3,0.9.B.0.224.288.5,0.10.B.0.288.288.6,0.5.B.0.224.384.7,0.16.B.0.224.128.8,0.15.A.270.96.48.9,0.8.A.0.128.48.10,0.17.A.90.160.48.11,0.22.B.0.176.48.12,0.22.A.0.112.160.13,0.4.A.0.272.80.14,0.12.B.0.272.96.15,0.19.A.90.416.48.16,0.21.B.0.256.144.17,0.1.B.0.80.192.18,0.11.A.0.256.208.19,0.3.A.0.224.352.20,0.20.A.0.544.112.21,0.6.B.0.352.160.22,0.6.B.0.192.160.23,0.4.A.90.208.256.24,0.22.A.180.48.160.25,0.22.A.90.144.288.26,0.22.A.90.144.192.27,0.13.A.270.112.320.28,0.22.A.0.48.320.29,0.22.A.90.48.256.30,0.22.A.90.48.192.31,0.14.B.0.144.256.32,0.14.B.0.240.48.33");
	
	AddMap("DT2 - Sample Dungeon 1,1.15.B.0.112.80.5....,1.27.A.0.112.64.6....,1.28.A.90.96.160.7....,1.11.B.0.304.304.8....,1.4.B.0.304.112.9....,1.24.B.0.272.144.10....,1.8.A.0.304.192.11....,1.25.B.90.48.288.12....,1.6.A.90.208.304.13....,1.22.B.0.208.208.14....,1.2.B.0.80.192.15....,1.28.A.90.160.160.16....,1.1.B.0.144.192.17....,1.9.A.0.112.208.18....,1.7.A.0.320.128.19....,1.7.A.0.320.288.20....,1.11.B.90.224.272.21....,1.20.B.0.224.240.22....,1.16.A.90.128.112.23....");
	AddMap("DT2 - Sample Dungeon 2,1.24.B.0.128.112.5....,1.21.A.90.48.176.6....,1.15.A.0.160.128.7....,1.20.B.0.48.144.8....,1.6.A.90.80.144.9....,1.7.B.0.96.144.10....,1.23.B.0.176.80.11....,1.13.B.90.288.112.12....,1.7.B.0.256.144.13....,1.10.B.90.240.32.14....,1.6.A.0.288.96.15....,1.14.B.0.160.16.16....");
	AddMap("DT2 - Sample Dungeon 3,1.2.B.0.368.80.5....,1.1.B.0.304.80.6....,1.24.A.270.32.32.7....,1.25.A.270.80.240.8....,1.21.A.0.192.80.9....,1.6.A.90.288.80.10....,1.15.B.90.304.272.11....,1.20.A.0.352.240.12....,1.13.A.0.336.336.13....,1.7.B.0.256.80.14....,1.12.B.0.304.208.15....,1.4.B.180.368.176.16....,1.5.B.0.304.144.17....,1.9.B.0.304.176.18....,1.8.B.0.336.128.19....,1.23.A.0.352.144.20.tile9.1.1.0");
}

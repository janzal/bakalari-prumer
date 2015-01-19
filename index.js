var express = require('express');
var app = express();

app.use(express.static(__dirname));

var port = process.env.PORT || 80;
app.listen(port, function () {
	console.log("Server is running on port " + port);
});
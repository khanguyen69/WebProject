const path = require('path');

const express = require('express');
const bodyParser = require('body-parser');

const app = express();

const mainRoutes = require('./routes/mainpage');
const adminRoutes = require('./routes/admin');
app.use(bodyParser.urlencoded({ extended: false }));
//app.use(bodyParser.json());
app.use(express.static(path.join(__dirname, 'public')));

/*app.use((req,res,next)=> {
    res.setHeader('Access-Control-Allow-Origin', '*');
    res.setHeader('Access-Control-Allow-Methods', 'GET,POST,PUT,PATCH,DELETE');
    res.setHeader('Access-Control-Allow-Headers', 'Content-Tyoe,Authorization');
    next();
});*/

app.use(mainRoutes);

//app.use('/admin',adminRoutes);

app.use((req,res,next) => {
    res.status(404).sendFile(path.join(__dirname,'views','404.html'));
});

app.listen(8080);
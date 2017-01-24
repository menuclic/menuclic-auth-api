'use strict';

const Hapi = require('hapi');
require('dotenv').config();

const authServer = new Hapi.Server();
authServer.connection({
    host: process.env.HOST,
    port: process.env.PORT
});

authServer.route({
    method: 'GET',
    path:'/auth',
    handler: function (request, reply) {
        console.log(request.login);
        console.log(request.password);
        //Validate session here
        return reply({});
    }
});

authServer.start(function (error) {
    if (error) {
        throw error;
    }

    console.log('Menuclic Auth API running at:', authServer.info.uri);
});
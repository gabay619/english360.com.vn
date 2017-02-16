var clc = require('cli-color');

exports.danger = function (mess,value) {
    console.log(clc.red(mess+": ") + clc.red(value));
};

exports.warning = function (mess,value) {
    console.log(clc.yellow(mess+": ") + clc.yellow(value));
};
exports.info = function (mess,value) {
    console.log(clc.green(mess+": ")+ clc.green(value));
};
exports.alert = function (mess,value) {
    console.log(clc.green(mess+": ")+ clc.white(value));
};
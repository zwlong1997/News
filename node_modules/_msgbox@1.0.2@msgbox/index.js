const boxen = require('boxen');
const chalk = require('chalk');
const size = require('window-size');
const wrap = require('wordwrap')(size.width - 14);

const boxenConfig = {
  borderStyle: {
    topLeft: ' ', topRight: ' ',
    bottomLeft: ' ', bottomRight: ' ',
    horizontal: ' ', vertical: ' ',
  },
  padding: { top: 1, right: 3, bottom: 1, left: 3 },
  margin: { top: 1, right: 2, bottom: 0, left: 3 },
  backgroundColor: 'black',
};

module.exports = function (title, message) {
  const titStr = `${chalk.red.bold(`${wrap(title)}`)}`;
  const mesStr = `${chalk.white(`${wrap(message)}`)}`;
  console.log(boxen(`${titStr}\n\n${mesStr}`, boxenConfig));
};

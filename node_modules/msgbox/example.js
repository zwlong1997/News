const messenger = require('./index');

// Long message
messenger('msgbox - improved console message output', `Simple and flexible message box for JavaScript CLI programs. Use msgbox to output longer, multi paragraph messages to the console and enjoy wordwrap functionality and pleasurable typographic composition inside a box that scales relative to the TTY width of the user.

message($title, $message)`);

// Short message
messenger('Hello', 'Or, just to say hello.');

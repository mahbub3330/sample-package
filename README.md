# Sample Project

## Installation 

Clone or download the package and rename it sample
move the sample package in root directory packages folder.

Update project composer.json file with

```
"repositories" : [
        {
            "type": "path",
            "url": "./packages/gglink/sample/"
        }
    ],
],
```

Go to terminal and run this command from project root

```
composer require gglink/sample
```


# Picasa

Picasa is a [TYPO3](http://typo3.org) extension which allows to browse and upload pictures to Picasa albums.

## Installation

Picasa is not on the [TYPO3 Extension Repository](http://typo3.org/extensions/repository) yet and will maybe never be because of the lack of time we are experiencing to write the documentation.  
In the mean time, feel free to [download the latest version](https://github.com/kryzalid/Picasa/zipball/master) and
put the uncompressed folder into `typo3conf/ext/`.  
Then simply install the extension via the **Extension Manager**.  
Don't forget to include the **Static TS Setup** in your root TypoScript template.  
You should now see two new plugins waiting for you to add them to any page you like.  

## Usage

The extension provides two plugins:  

- One to display a list of albums from a Picasa accounts.
- Another to upload pictures to the aforementioned albums.

Just put of one these plugin on an page you like, set the Picasa credentials in the FlexForm and enjoy ! 

## Author

This extension has been written by [Romain Ruetschi](https://github.com/romac).

## License

This extension is licensed under the [GNU General Public License v3](http://www.gnu.org/licenses/gpl.html).  
This was not our call but a requirement due to TYPO3's license, which is the GPL v3.
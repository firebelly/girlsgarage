# Girls Garage
Built with [Bedrock](https://roots.io/bedrock/)

## Note on versions 
Dev/deployment currently working with `ruby 2.3.0` and `node 5.12.0` as specified in `.ruby-version` and `.nvmrc` files.  

Node 6 breaks the gulp process for sprites at present due to a bug in a deeper dependency of package `sprity`--this package may need to be replaced in the future if they do not address the issue.  For now, since we are only doing minor edits, you can use nvm and run `nvm use` (which will reference the present `.nvmrc` files) in both the root project directory (before deploying) and in theme directory (before gulping).

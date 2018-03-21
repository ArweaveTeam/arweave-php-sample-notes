# Arweave Notes
A sample PHP application which uses the  [Arweave PHP SDK](https://packagist.org/packages/arweave/arweave-sdk) to store and retrieve data from the Arweave.

All notes on this demo application are 100% public, so don't send anything you wouldn't want in the public domain.

This project is for educational purposes only, to demonstrate and suggest how you might use the SDK and interact with the Arweave network. Caution must be taken if any live keys are used, or if you intend to use this as the basis for any publicly accessible application.

## Getting started

### Requirements
Make sure you have [Git](https://git-scm.com), [Vagrant](https://www.vagrantup.com) and [VirtualBox](http://virtualbox.org) (or another suitable [Vagrant provider](https://www.vagrantup.com/docs/providers)) installed.

### Installation

#### Git
Firstly we need to clone the repo
```
$ git clone git@github.com:ArweaveTeam/arweave-php-sample-notes.git arweave-notes
```
This will clone the repo into a directory named `arweave-notes`.


#### Vagrant
A Vagrantfile is included to help us get an Ubuntu 16.04, Apache 2.4 and PHP 7.0 environment up and running quickly. 

From inside the newly cloned directory, we simply need to run the following

```
$ vagrant up
```
This step will probably take a few minutes depending on your internet connection, so you should have just enough time for a coffee.

**Notes about Vagrant (or lack thereof)**

Using Vagrant isn't strictly required and any \*nix + Apache + PHP environment should work just fine. A few non-standard PHP modules are required so check out the [provision.sh](https://github.com/ArweaveTeam/arweave-php-sample-notes/blob/master/provision.sh) file for dependencies.


#### Composer
Once our VM is up and running we need to SSH into it and run composer.
```text
$ vagrant ssh
```
Then from inside the Vagrant SSH session we simply run the following
```text
ubuntu@ubuntu-xenial$ cd /var/www/html/app/
ubuntu@ubuntu-xenial$ composer install
```

#### Configuration

All that's needed to configure the application is your key file (JWK) so we can sign transactions and submit data.

In the project directory you should see a `storage` directory which should only contain one file, `nodes.json`. In this directory we need to create a file called `wallet.json`, we then need to save our JWK in this file.

Once you're done, `storage/wallet.json` should contain a valid JSON structure only, and look something like this
```
{"kty":"RSA","ext":true,"e":"RFE","n":"Ly7R2wiFXcbNApKYXzo0i12J8anh3x...
```

**You should treat your JWK as you would treat an API key or a password**. You should **never** expose them or place them in any publicly accessible location and **never** commit them to any version control system, **doing so could compromise your wallet and its contents**.

This project has `storage/wallet.json` already added to `.gitignore` to prevent it from going into version control. **Do not remove this**.

## Usage

With your VM up and running, head over to http://localhost:8080 (or whichever port you specified/modified in your Vagrantfile).

Click the '+' button to create a new note.

Enter a note subject and body, then click the tick button in the upper right, you'll then be presented with a warning

> Are you sure? Remember, all notes are public and permanent.

Assuming you're happy for this note to be permanently preserved on the network, click the tick and you're done – you've sent your first bit of data to the Arweave! 🎉🎉🎉

**Notes**

Newly created notes may take a few minutes to become available, as they have to wait to be mined into the next block.

After creating a note, if you check out `storage/notes.json` you'll see this file is tracking the transaction IDs for all of your notes, the contents of the notes isn't stored locally as that is fetched from the Arweave network at runtime.

Apache logs can be found in `logs/apache-access.log` and `logs/apache-error.log` in the application directory.


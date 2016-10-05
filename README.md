Developing using Vagrant

Install Virtual Box
Download the latest version of VirtualBox
https://www.virtualbox.org/

Install Vagrant
Download Vagrant at http://www.vagrantup.com/

Working with Vagrant
Start the vagrant vm (on first boot this will take some time while the machine is configured):

```
$ vagrant up
```

To access the shell run:

```
$ vagrant ssh
```

Would normally use a provisioner but for simplicity inside the VM run the setup.sh which should setup an working environment for you. 

```
$ cd /vagrant
```

Run the setup, leaving the mysql root password blank...

```
$ ./setup.sh 
```

Access the site via:

```
http://33.33.33.33:8000/app_dev.php/api/v1/countries
```

The project files are accessible inside the vm at:

/vagrant

And you can run the Symfony console in /vagrant by:

```
$ php app/console
```

Import script is

```
php app/console countries:import
```
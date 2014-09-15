Vagrant.configure("2") do |config| 
	config.vm.box = "precise64"
	config.vm.box_url = "http://files.vagrantup.com/precise64.box"
	config.vm.provision :shell, :path => "bootstrap.sh"
	config.vm.network :private_network, ip: "150.150.150.150"
	config.vm.network "forwarded_port", guest: 80, host: 8000
	#config.vm.synced_folder "www/", "/www", owner: "www-data", group: "root"
	config.vm.synced_folder "C:\\Dev\\www", "/var/www", id: "vagrant-root"
end

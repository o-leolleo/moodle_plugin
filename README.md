# moodle_plugin
Some experiments on developing a simple moodle plugin, a first step to a bigger project.

## Configuring the enviroment

### Some considerations

This project uses the moodle docker [bitnami image](https://hub.docker.com/r/bitnami/moodle/~/dockerfile/),
with some ammendments (very few), such as mapping the plugins directory to the container `$HOME/plugins`.

It could be the case of mapping the `distance` folder directly into
the `/opt/bitnami/moodle/report/distance` folder (take a look at the docker-compose.yml file).
However I've chosen not to put changes directly onto the real plugin folder, alternatively
doing it through the `cp -r ~/plugins/distance/ /opt/bitnami/moodle/report/`
command, in some sort of folder 'protection' but not sure if this is useful.

So, to start with a runnig moodle install with the newer 3.4.1 version, just

### install docker onto your machine...

If in debian based GNU/Linux ditro, just issue

```bash
$ sudo apt install docker
```

or if, like me, you use arch-linux just use pacman through

```bash
$ sudo pacman -S docker
```
- **LOOK** I had issues installing docker on my arch-linux PC,
	since, after installing docker, running `$ systemctl start docker`
	didn't work... I've rebooted and everything went ok.

and of course take a look onto [arch-wiki entry on docker](https://wiki.archlinux.org/index.php/Docker).

You may have to install `docker-compose` in order to use it, so you may have to issue (assuming arch-linux)

```bash
$ sudo pacman -S docker-compose
```

### Do the compose nice step!

make sure that you have **sudo permissions**
or are in the **docker** ([be aware](https://github.com/moby/moby/issues/9976)) group
and run

```bash
$ docker-compose up
```

or alternatively run it on background through

```bash
$ docker-compose up -d
```

I prefer the first one since you can see the progress of the process and it took
some time on my machine, so be patient.

### Load a backup if you have it and want it (of course)

You can access the running container as if it was a real machine, so you can connect
to the mariabd instance of the compose service and load (or restore from) a backup right into it.

The compose service creates containers names based on docker-compose.yml current directory name by default.

So, if you have it on a moodle folder, you'll end up with a moodle_mariadb_1 running container for
the database container and moodle_moodle_1 for the moodle application container.

Then you can run a command (not sure if this is the cleanest way of doing it, I'm just starting into docker world :)
like

```bash
$ mysql moodle -u root -h 172.18.0.2 < $backup
```

Assuming $backup as your backup file path.

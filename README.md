### ElevatorSim

## Quick guide

### Requirements

* docker https://www.docker.com/
* docker-compose https://docs.docker.com/compose/
* kubectl https://kubernetes.io/docs/tasks/tools/install-kubectl/
* minikube https://kubernetes.io/docs/tasks/tools/install-minikube/

### Get started

Clone the project: 

```sh
$ git clone git@github.com:Polinicles/ElevatorSim.git
$ cd ElevatorSim
```

## Docker

Start the project

```sh
$ docker-compose up -d
```

Connect to the bash of the PHP container

```sh
$ docker-compose exec php bash
```

## Commands

### Generate Calls from defined Sequences

Inside the running container:

```sh
$ bin/console app:call:generate
```

The sequences and elevators number are defined in the ```AppFixtures.php```

### Generate report of the calls

Inside the running container:

```sh
$ bin/console app:call:process
```

There's a report file generated called ```report.txt```

## Kubernetes

The environment is read to deploy but it needs to define an image hub like GCR

```sh
gcr.io/{gce-project}/{name-of-image}
```

Once defined, it has to tag and push the image to the hub

##Improvements

- Use InMemory Repository type instead of MySQL
- Create MakeFile
- Run unit tests
- Manage calls that can't be answered when there're not enough elevators

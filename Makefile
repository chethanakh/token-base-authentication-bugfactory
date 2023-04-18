#!/usr/bin/make

SHELL = /bin/sh

UID := $(shell id -u)
GID := $(shell id -g)

export UID
export GID

shell:
	docker-compose -f docker-compose.local.yaml exec -u ${UID}:${GID} tba-app sh

up:
	UID=${UID} GID=${GID} docker-compose -f docker-compose.local.yaml up --build -d --remove-orphans

down:
	docker-compose -f docker-compose.local.yaml down --remove-orphans

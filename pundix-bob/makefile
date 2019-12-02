scp514:
	npm run build:prod
	scp -r dist test-0514:/webserver/nginx_html/pundix-bob

PROJECT_NAME = pundix-bob

# New tag
VERSION = 0.0.1
TAG_NAME = $(PROJECT_NAME)-$(shell date +"%Y-%m-%d")-v$(VERSION)
tag:
	# New tag
	git tag	$(TAG_NAME)
	# Remote new tag
	git push origin $(TAG_NAME)


# Del tag
RM_VERSION = 0.0.1
RM_TIME = 2019-11-08
rmTag:
	# Del local tag
	git tag -d $(PROJECT_NAME)-$(RM_TIME)-v$(RM_VERSION)
	# Del remote tag
	git push origin :refs/tags/$(PROJECT_NAME)-$(RM_TIME)-v$(RM_VERSION)


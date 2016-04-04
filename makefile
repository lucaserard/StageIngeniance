all: general

general:
	d="ls -d */";\
	for f in $$d ; do\
		# cd $$f && $(MAKE)&&cd -; \
		$(MAKE) -C "$$f";\
	done

clean:
	d="ls -d */";\
	for f in $$d ; do\
		# cd $$f && $(MAKE) clean&&cd -; \
		$(MAKE) clean -C "$$f";\
	done

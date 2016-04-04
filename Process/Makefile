all: general self

self: 
	pdflatex ProcessusIngeniance.tex;
	pdflatex ProcessusIngeniance.tex;
	rm *.aux
	rm *.log	
	rm *.out	
	rm *.cb	
	rm *.cb2
	rm *.toc
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
	rm -f *.pdf 

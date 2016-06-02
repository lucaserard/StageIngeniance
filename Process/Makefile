#SHELL := /bin/bash
all: general self

self: 
	#pdflatex "\def\current{$d}\input{ProcessusIngeniance.tex}" ;
	#pdflatex "\def\current{$(pwd)}\input{ProcessusIngeniance.tex}" ;	
	pdflatex ProcessusIngeniance.tex;	
	pdflatex ProcessusIngeniance.tex;
	pdflatex ProcessusIngeniance.tex;
	-rm *.aux *.log *.out *.toc *.cb *.cb2
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

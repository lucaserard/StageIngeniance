all: dia tex

tex:
	pdflatex DocumentRecrutement.tex
	pdflatex DocumentRecrutement.tex
	-rm *.aux *.log *.out *.toc
dia: 
	for dia in Diagrammes/*.dia; do\
		if [ ! -e $${dia%%.*}.eps ]; then\
			dia -e $$dia.eps -t eps $$dia;\
			ps2pdf -dEPSCrop $$dia.eps $${dia%%.*}.pdf;\
			echo "$dia";\
		fi;\
	done;\
	rm -f Diagrammes/*.eps
clean:
	rm -f Diagrammes/*.eps
	rm -f Diagrammes/*.pdf
	rm -f *.pdf 

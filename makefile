all: dia 

dia: 
	for dia in Process/*.dia; do\
		if [ ! -e $${dia%%.*}.eps ]; then\
			dia -e $$dia.eps -t eps $$dia;\
			ps2pdf -dEPSCrop $$dia.eps $${dia%%.*}.pdf;\
		fi;\
	done;\
	rm -f Process/*.eps

clean:
	rm Process/*.pdf
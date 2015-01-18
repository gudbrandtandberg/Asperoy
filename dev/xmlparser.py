# Skript som skriver ut filstrukturen i ../model/bilder mappen til en xml-fil

import glob

bilderurl = "../model/bilder"
xmlfile = open("../model/bilder.xml", "w")

xmlfile.write("<BILDER>\n")

for albumpath in glob.glob(bilderurl+"/*"):
	path = albumpath.split("/")
	album = path[-1]
	albumid = album.replace(" ", "")
	xmlfile.write("""  <ALBUM ID='"""+albumid+"""' NAVN='"""+album+"""'>\n""")

	for bildepath in glob.glob(albumpath+"/*"):
		path = bildepath.split("/")
		bilde = path[-1]
		xmlfile.write("""    <BILDE FIL='"""+bilde+"""'></BILDE>\n""")

	xmlfile.write("  </ALBUM>\n")

xmlfile.write("</BILDER>\n")

<?php
include('writelog.php');
session_start();
writelog("mrpdblog.txt", "Logout utente ".$_SESSION['who']);
session_destroy();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
	<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=utf-8">
	<TITLE></TITLE>
	<meta name="generator" content="Bluefish 2.2.4" >
	<META NAME="CREATED" CONTENT="20050522;15550400">
	<META NAME="CHANGED" CONTENT="20050522;16443900">
</HEAD>
<BODY LANG="en-US" DIR="LTR">
<P ALIGN=CENTER><FONT COLOR="#000080"><FONT SIZE=6 STYLE="font-size: 28pt">MUSEO DELLA RESISTENZA DI SPERONGIA</FONT></FONT></P>
<HR>
<P ALIGN=CENTER><IMG SRC="immagini/mrp266.jpg" NAME="Immagine1" ALIGN=BOTTOM WIDTH=168 HEIGHT=229 BORDER=0></P>
<P ALIGN=CENTER>log out effettuato, fai click su <B><FONT SIZE=5><A HREF="index.php">AVANTI</A>
</FONT></B>per continuare.</P>
<P ALIGN=CENTER><BR><BR>
</P>
</BODY>
</HTML>
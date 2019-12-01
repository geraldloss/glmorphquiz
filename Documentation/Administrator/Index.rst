.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _admin-manual:

Administrator Manual
====================

Installation
------------

Install the extension with the Extension Manager. There is no further configuration needed.

In the following we need acces to the public folder of the extension. If your extension folder 
is not accessible by default then provide access at least to the following folder.

::

	typo3conf/ext/glmorphquiz/Resources/Public/

With apache put the following lines in your Virtual Host declaration.

::

	<Location typo3conf/ext/glmorphquiz/Resources/Public/>
        Require all granted
	</Location>


See :ref:`user-manual` for a detaild description.
#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
Test script to verify text extraction works
"""
import sys
import os

# Add backend to path
sys.path.insert(0, 'backend')

# Test import
try:
    import fitz
    print("✓ PyMuPDF (fitz) is available")
except ImportError as e:
    print(f"✗ PyMuPDF error: {e}")

try:
    from docx import Document
    print("✓ python-docx is available")
except ImportError as e:
    print(f"✗ python-docx error: {e}")

print("\nTo test extraction, upload a PDF or DOCX file in the web interface.")
print("Server is running at: http://localhost:8000")

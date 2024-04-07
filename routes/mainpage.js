const path = require('path');

const express = require('express');

const rootDir = require('../util/path')

const router = express.Router();

router.get('/', (req, res, next) => {
    res.sendFile(path.join(rootDir, 'views', 'index.html'));
  });

router.get('/dichvuindex.html', (req, res, next) => {
    res.sendFile(path.join(rootDir, 'views', 'dichvuindex.html'));
  });
router.get('/tranglienhe+dkthongtin.html', (req, res, next) => {
    res.sendFile(path.join(rootDir, 'views', 'tranglienhe+dkthongtin.html'));
  });
router.get('/trangthai.html', (req, res, next) => {
    res.sendFile(path.join(rootDir, 'views', 'trangthai.html'));
  });
router.get('/hoso.html', (req, res, next) => {
    res.sendFile(path.join(rootDir, 'views', 'hoso.html'));
  });
router.get('/datlich.html', (req, res, next) => {
    res.sendFile(path.join(rootDir, 'views', 'datlich.html'));
  });
router.get('/dangnhap.html', (req, res, next) => {
    res.sendFile(path.join(rootDir, 'views', 'dangnhap.html'));
  });
module.exports = router;
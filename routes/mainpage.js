const path = require('path');

const express = require('express');

const rootDir = require('../util/path')

const router = express.Router();


router.get('/', (req, res, next) => {
    res.render('index', {
      pageTitle: 'Petopia - Thiên đường cho thú cưng',
      path: '/',
    });
  });
  router.get('/dichvuindex', (req, res, next) => {
    res.render('dichvuindex', {
      pageTitle: 'Petopia - Thiên đường cho thú cưng',
      path: '/dichvuindex',
    });
  });
  router.get('/tranglienhe_dkthongtin', (req, res, next) => {
    res.render('tranglienhe_dkthongtin', {
      pageTitle: 'Petopia - Thiên đường cho thú cưng',
      path: '/tranglienhe_dkthongtin',
    });
  });
  router.get('/trangthai', (req, res, next) => {
    res.render('trangthai', {
      pageTitle: 'Petopia - Thiên đường cho thú cưng',
      path: '/trangthai',
    });
  });
  router.get('/hoso', (req, res, next) => {
    res.render('hoso', {
      pageTitle: 'Petopia - Thiên đường cho thú cưng',
      path: '/hoso',
    });
  });
  router.get('/datlich', (req, res, next) => {
    res.render('datlich', {
      pageTitle: 'Petopia - Thiên đường cho thú cưng',
      path: '/datlich',
    });
  });
  router.get('/dangnhap', (req, res, next) => {
    res.render('dangnhap', {
      pageTitle: 'Petopia - Thiên đường cho thú cưng',
      path: '/dangnhap',
    });
  });

module.exports = router;
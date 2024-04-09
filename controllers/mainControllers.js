router.get('/', (req, res, next) => {
    res.render('index', {
      pageTitle: 'Petopia - Thiên đường cho thú cưng',
      path: '/',
    });
  });
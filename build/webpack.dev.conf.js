'use strict'
const utils = require('./utils')
const webpack = require('webpack')
const config = require('../config')
const merge = require('webpack-merge')
const path = require('path')
const baseWebpackConfig = require('./webpack.base.conf')
const CopyWebpackPlugin = require('copy-webpack-plugin')
const HtmlWebpackPlugin = require('html-webpack-plugin')
const FriendlyErrorsPlugin = require('friendly-errors-webpack-plugin')
const portfinder = require('portfinder')

//自已要引入的
const express = require('express');
const http = require('http');
const bodyParser = require('body-parser');
const mutipart= require('connect-multiparty');
const mutipartMiddeware = mutipart();
const md5 = require('md5');
const iconv = require('iconv-lite');
const BufferHelper = require('bufferhelper');
const db = require('../config/db');
const nodemailer = require("nodemailer");
const smtpTransport = require('nodemailer-smtp-transport');
const wellknown = require("nodemailer-wellknown");
const setConfig = wellknown("163");   //所选择的第三方服务
const Home=require(path.join(__dirname,'../static/js/helper'));

setConfig.auth = {
  user:'13113738378@163.com',  //邮件账号
  pass:'zwl6661294'   //这里密码不是qq,163密码，是你设置的smtp授权密码
}

var transporter = nodemailer.createTransport(smtpTransport(setConfig));

const HOST = process.env.HOST
const PORT = process.env.PORT && Number(process.env.PORT)




//创建一个express 应用
const app = express();
const apiRoutes = express.Router();

//parse application/x-www-form-urlencoded bodyParser中间层
app.use(bodyParser.urlencoded({extended:false}));

//设置上传文件的目录
app.use(mutipart({uploadDir:path.join(__dirname,"../uploads")}));

const devWebpackConfig = merge(baseWebpackConfig, {
  module: {
    rules: utils.styleLoaders({ sourceMap: config.dev.cssSourceMap, usePostCSS: true })
  },
  // cheap-module-eval-source-map is faster for development
  devtool: config.dev.devtool,

  // these devServer options should be customized in /config/index.js
  devServer: {
    before(apiRoutes){
      apiRoutes.get('/channel',function(req,res){

        // let channel = '';
        // let url = encodeURI('http://api.jisuapi.com/news/channel?appkey=038378d4d815d43a')
        // let getChannel = new Promise((resolve, reject) => {
        //   http.get(url, response => {
        //     response.on('data', data => {
        //       channel += data
        //     })
        //     response.on('end', () => {
        //       resolve(channel)
        //     })
        //   })
        // })
        // getChannel.then(channel => {
        //   channel = JSON.parse(channel)
        //   res.json(channel)
        // })

        //db
        new Promise((resolve,reject) => {
          db.table('news_cate').select().then(function(cate_list)
          {
            console.log(cate_list);
            resolve(cate_list);
            res.json(cate_list);
          });
        });
      });

      apiRoutes.get('/channel/:item',function(req,res){
        let item = req.params.item;
        let limit = 10;
        new Promise((resolve,reject) => {
          db.table('news').alias('news').join({
            table:'news_cate',
            join:'left',
            as:'cate',
            on:['news_cate_id','news_cate_id']
          }).where(`news_cate_name = '${item}'`).order('news_id DESC').limit(limit).select().then(function(news_list)
          {
            resolve(news_list);
            res.json(news_list);
          });
        });
      });
      apiRoutes.get('/channelRefresh/:item/:page',function(req,res){
        let item = req.params.item;
        let page = req.params.page ? parseInt(req.params.page) : 1;
        let limit = 10;
        let start = (page-1)*limit;
        new Promise((resolve,reject) => {
         db.table('news').alias('news').join({
            table:'news_cate',
            join:'left',
            as:'cate',
            on:['news_cate_id','news_cate_id']
          }).where(`news_cate_name = '${item}'`).order('news_id DESC').limit(start,limit).select().then(function(data){
            resolve(data);
            res.json(data);
          });
        });
      });
      apiRoutes.get('/channelCount/:item',function(req,res){
        let item = req.params.item;
        new Promise((resolve,reject) =>{
          db.table('news').alias('news').join({
            table:'news_cate',
            join:'left',
            as:'cate',
            on:['news_cate_id','news_cate_id']
          }).where(`news_cate_name = '${item}'`).count('*').then(function(count)
          {
            resolve(count);
            res.json(count);
          })
        })
      });
     
      apiRoutes.get('/search/:item',function(req,res)
      {
        let item=req.params.item;
            return new Promise((resolve,reject)=>{
              db.table('news').alias('news').join({
                table:'news_cate',
                join:'left',
                as:'news_cate',
                on:['news_cate_id','news_cate_id']
              }).where(`news_cate_name = '${item}'`).select().then(function(search)
              {
                resolve(search);
                res.json(search);
              })
            })
      });

      apiRoutes.get('/news/:page',function(req,res){
        let page = req.params.page ? parseInt(req.params.page) : 1;
        let limit = 10;
        let start = (page-1)*limit;
        new Promise((resolve,reject) => {
          db.table('news').order("news_id DESC").limit(start,limit).select().then(function(data){
              resolve(data);
              res.json(data);
          });
        });
      });
      apiRoutes.get('/news_count',function(req,res){
        new Promise((resolve,reject) => {
          db.table('news').count('*').then(function(count){
            resolve(count);
            res.json(count);
          });
        });
      });

      apiRoutes.post('/register',function(req,res){
        let user_name = req.body.user_name;
        let user_pwd = req.body.user_pwd;
        new Promise((resolve,reject) => {


          db.table('user').where(`user_name = '${user_name}'`).find().then(checkUser => {
            if(JSON.stringify(checkUser) != "{}")  //已经被人注册了  {} == true
            {
              reject({});
              res.json({});
            }else{
              var data = {
                "user_name":user_name,
                "user_pwd":md5(user_pwd),
                "user_time":parseInt(Date.now()/1000),
              };

              db.table('user').add(data).then(user_id => {
                if(user_id)
                {
                  db.table('user').where(`user_id = ${user_id}`).find().then(user => {
                    resolve(user);
                    res.json(user);
                  });
                }else{
                    reject({});
                    res.json({});
                }
              });


            }
          });
        })
      });

      apiRoutes.post('/login',function(req,res)
      {
        let user_name = req.body.user_name;
        let user_pwd = req.body.user_pwd;
        new Promise((resolve,reject) => {
          let where = `user_name = '${user_name}' AND user_pwd = '${md5(user_pwd)}'`;
          db.table('user').where(where).find().then(user => {
            if(JSON.stringify(user.data) != "{}")
            {
              resolve(user);
              res.json(user);
            }else{
              reject({});
              res.json({});
            }
          })
        })
      })

      apiRoutes.get('/videoCate',function(req,res)
      {
        new Promise((resolve,reject) => {
          db.table('video_cate').select().then(function(video_cate){
            resolve(video_cate);
            res.json(video_cate);
          })
        })
      });

      apiRoutes.get('/getvideo/:item',function(req,res){
        let item = req.params.item;
        new Promise((resolve,reject) => {
          db.table('video').alias('video').join({
            table:'video_cate',
            join:'left',
            as:'video_cate',
            on:['video_cate_id','video_cate_id']
          }).where(`video_cate_name_ch = '${item}'`).select().then(function(video_list)
          {
            resolve(video_list);
            res.json(video_list);
          })
        })
      })

      apiRoutes.get('/news_page/:item',function(req,res)
      {
        let item = req.params.item;
        new Promise((resolve,reject) => {
          db.table('news').where(`news_id = ${item}`).find().then(function(news_page_list)
          {
            resolve(news_page_list);
            res.json(news_page_list);
          })
        })
      })

      apiRoutes.get('/commitCm/:Cm/:user_id/:news_id',function(req,res)
      {
        let Cm = req.params.Cm;
        let user_id = req.params.user_id;
        let news_id = req.params.news_id;
        new Promise((resolve,reject) =>{
          let arr=new Array();
          arr['comment_content'] = Cm;
          arr['comment_time'] = Date.parse(new Date());
          arr['user_id'] = user_id;
          arr['news_id'] = news_id;
          arr['type_id'] = 1;
          db.table('comment').add(arr).then(function(insertId)
          {
            resolve(insertId);
            res.json(insertId);
          })
        })
      })

      apiRoutes.get('/comments/:news_id',function(req,res)
      {
        let news_id = req.params.news_id;
        new Promise((resolve,reject) => {
          db.table('comment').alias('comment').join({
            table:'user',
            join:'left',
            as:'user',
            on:['user_id','user_id']
          }).where(`news_id = ${news_id}`).order("comment_id DESC").select().then(function(comments)
          {
            resolve(comments);
            res.json(comments);
          })
        })
      })

      apiRoutes.get('/like/:id',function(req,res)
      {
        let id = req.params.id;
        new Promise((resolve,reject) => {
          db.table('comment').where(`comment_id = ${id}`).find().then(function(like)
          {
            let comment_like = like.comment_like+1;
            let arr=new Array();
            arr['comment_like'] = comment_like;
            db.table('comment').where(`comment_id = ${id}`).update(arr).then(function(affectedId)
            {
              resolve(affectedId);
              res.json(affectedId);
            })
          })
          
        })
      })

      apiRoutes.get('/initUser',function(req,res)
      {
        new Promise((resolve,reject) => {
          db.table('comment').count('*').then(function(Cmcount){
            db.table('message').count('*').then(function(Mgcount){
              let data={
                'comment':Cmcount,
                'message':Mgcount
              } 
              resolve(data);
              res.json(data);
            })
          })
        })
      })

      apiRoutes.get('/myComment/:user_id',function(req,res)
      {

        let user_id = req.params.user_id;
        new Promise((resolve,reject) =>{
          db.table('comment').where(`user_id = ${user_id}`).select().then(function(myCommentList)
          {
            resolve(myCommentList);
            res.json(myCommentList);
          })
        })
      })

      apiRoutes.post('/commitMg',function(req,res)
      {
        let user_id = req.body.user_id;
        let msg_type = req.body.type;
        let msg_content = req.body.Mgcontent;
        var data = {
            "msg_content":msg_content,
            "msg_time":parseInt(Date.now()),
            "msg_type":msg_type,
            "user_id":user_id
        };
        new Promise((resolve,reject) =>{
          db.table('message').add(data).then(function(insertId)
          {
            resolve(insertId);
            res.json(insertId);
          })
        })
      })

      apiRoutes.get('/email/:email',function(req,res)
      {
        let email = req.params.email;
        new Promise((resolve,reject) =>{
          var mailOptions = {
            from:"13113738378@163.com",
            to:email,
            subject:'用户验证',
            text:"text plain",
            html:"验证成功"
          }

          transporter.sendMail(mailOptions,function(error,info){
            if(error){
              return console.log(error);
            }
            resolve(info.response);
            res.json(info.response);
          })
        })
      })

      apiRoutes.get('/newslikeAdd/:news_id/:user_id',function(req,res)
      {
        let news_id = req.params.news_id;
        let user_id = req.params.user_id;
        new Promise((resolve,reject) => {
          db.table('user').where(`user_id = ${user_id}`).find().then(function(user_list){
            db.table('news').where(`news_id = ${news_id}`).find().then(function(news_list){
              let user_collect = user_list.user_collect.split(',');
              if(Home.inArray(user_collect,news_id)){
                let index = user_collect.indexOf(news_id);
                user_collect.splice(index,1);
                var newsLike = {
                  'news_like':news_list.news_like-1
                }
                var newsCollect = {
                  'user_collect':user_collect.join(',')
                }
                db.table('user').where(`user_id = ${user_id}`).update(newsCollect).then(function(affectedId){
                  db.table('news').where(`news_id = ${news_id}`).update(newsLike).then(function(affectedId){
                    resolve(affectedId);
                    res.json(affectedId);
                  })
                })
              }else{
                user_collect.push(news_id);
                var newsLike = {
                  'news_like':news_list.news_like+1
                }
                var newsCollect = {
                  'user_collect':user_collect.join(',')
                }
                db.table('user').where(`user_id = ${user_id}`).update(newsCollect).then(function(affectedId){
                  db.table('news').where(`news_id = ${news_id}`).update(newsLike).then(function(affectedId){
                    resolve(affectedId);
                    res.json(affectedId);
                  })
                })
              }
            })
          })
        })
      })

      apiRoutes.get('/collections/:user_id',function(req,res){
        let user_id = req.params.user_id;
        new Promise((resolve,reject)=>{
          db.table('user').where(`user_id = ${user_id}`).find().then(user_list =>{
            let user_collect = user_list.user_collect;
            db.table('news').where(`news_id IN (${user_collect})`).select().then(news_list =>{
              resolve(news_list);
              res.json(news_list);
            }) 

          })
        })
      })

      




     

      app.use('/api',apiRoutes);  //设置路由
      app.listen(8888); //监听8888
    },
    clientLogLevel: 'warning',
    historyApiFallback: {
      rewrites: [
        { from: /.*/, to: path.posix.join(config.dev.assetsPublicPath, 'index.html') },
      ],
    },
    hot: true,
    contentBase: false, // since we use CopyWebpackPlugin.
    compress: true,
    host: HOST || config.dev.host,
    port: PORT || config.dev.port,
    open: config.dev.autoOpenBrowser,
    overlay: config.dev.errorOverlay
      ? { warnings: false, errors: true }
      : false,
    publicPath: config.dev.assetsPublicPath,
    proxy: config.dev.proxyTable,
    quiet: true, // necessary for FriendlyErrorsPlugin
    watchOptions: {
      poll: config.dev.poll,
    }
  },
  plugins: [
    new webpack.DefinePlugin({
      'process.env': require('../config/dev.env')
    }),
    new webpack.HotModuleReplacementPlugin(),
    new webpack.NamedModulesPlugin(), // HMR shows correct file names in console on update.
    new webpack.NoEmitOnErrorsPlugin(),
    // https://github.com/ampedandwired/html-webpack-plugin
    new HtmlWebpackPlugin({
      filename: 'index.html',
      template: 'index.html',
      inject: true
    }),
    // copy custom static assets
    new CopyWebpackPlugin([
      {
        from: path.resolve(__dirname, '../static'),
        to: config.dev.assetsSubDirectory,
        ignore: ['.*']
      }
    ])
  ]
})

module.exports = new Promise((resolve, reject) => {
  portfinder.basePort = process.env.PORT || config.dev.port
  portfinder.getPort((err, port) => {
    if (err) {
      reject(err)
    } else {
      // publish the new Port, necessary for e2e tests
      process.env.PORT = port
      // add port to devServer config
      devWebpackConfig.devServer.port = port

      // Add FriendlyErrorsPlugin
      devWebpackConfig.plugins.push(new FriendlyErrorsPlugin({
        compilationSuccessInfo: {
          messages: [`Your application is running here: http://${devWebpackConfig.devServer.host}:${port}`],
        },
        onErrors: config.dev.notifyOnErrors
        ? utils.createNotifierCallback()
        : undefined
      }))

      resolve(devWebpackConfig)
    }
  })
})

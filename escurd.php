创建索引并设置字段类型
PUT test
{
  "mappings":{
    "properties":{
      "id":{
        "type":"integer"
      },
      "name":{
        "type":"text"
      },
      "age":{
        "type":"integer"
      },
      "sex":{
        "type":"text"
      },
      "post_time":{
        "type": "date",
				"format": "yyyy-MM-dd HH:mm:ss"
      }
    }
  }
}

查看索引字段
GET test/

搜索全部数据
GET test/_search

添加一条数据
POST test/_doc/1
{
  "id":"1",
  "name":"张三",
  "age":"22",
  "sex":"male",
  "post_time":"2020-05-01 14:14:21"
}

修改数据（不会覆盖）
POST /test/_doc/1/_update
{
  "doc":{
    "name":"小米"
  }
}


修改数据（会覆盖）
PUT /test/_doc/1
{
  "doc":{
    "name":"小米"
  }
}

 
组合查询（年龄小于等于50岁，性别为unlimited或者为male的人）
GET test/_search
{
   "query": {
        "bool": {
            "must": [
                {
                  "range": {
                      "age": {
                          "lte": "50"
                      }
                    }
                },
              {
                "bool":{
                  "should": [
                    {
                      "term": {
                        "sex": "unlimited"
                      }
                    },
                    {
                      "term": {
                        "sex": "male"
                      }
                    }
                  ]
                }
              }
            ]
        }
   },
   "sort": {
        "post_time": {
            "order": "DESC"
        }
    },
    "from": "0",
    "size": 2
}

删除一条数据
DELETE /test/_doc/1

删除test整个索引
DELETE /test/


启动Logstash
./bin/logstash -f config/mysqlsyn.conf
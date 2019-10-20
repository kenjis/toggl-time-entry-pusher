# toggl-time-entry-pusher

## Specs

### Text File Format

```
2019/10/18（金）
■本日の報告
09:30-10:00[30] FOO #1110 クラス設計
10:00-10:25[25] BAROPS ログ確認
10:25-11:00[35] BAR #2222 モデルの実装

2019/10/17（木）
■本日の報告
09:30-10:00[30] FOOOPS #1111 バグ調査
10:00-10:25[25] BAROPS ログ確認
```

## How to Run

```
$ php get-project-list.php
```

```
$ time php push-time-entries.php time-record.txt
```

## How to Debug

```
$ curl -v -u <API token>:api_token -X GET https://www.toggl.com/api/v8/workspaces
```

```
$ curl -v -u <API token>:api_token -X GET https://www.toggl.com/api/v8/workspaces/<wid>/projects
```

## References

- https://github.com/toggl/toggl_api_docs/blob/master/chapters/time_entries.md
- http://docs.guzzlephp.org/en/stable/

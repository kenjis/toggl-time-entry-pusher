# toggl-time-entry-pusher

This app reads a text file which has your time recording log,
and pushes the time entries to Toggl API.

## Specs

### Text File Format

#### Format

``` 
<Date>
<Start>-<Stop>[<Minutes>] <Project Code> <Description>
```

| Item           |  Format  |
|----------------|----------|
|`<Date>`        |YYYY/MM/DD|
|`<Start>`       |HH:MM     |
|`<Stop>`        |HH:MM     |
|`<Minutes>`     | `[0-9]`  |
|`<Project Code>`| `[A-Z]`  |

#### Project Code

If you define project code suffix, you can use tags in Toggl.

When you have a project code `FOO`, if you use the project code `FOOOPS` 
(you define the suffix `OPS` means the tag `operation`),
you can make a time entry which has the tag `operation` of the project `FOO`.

#### Example

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

## How to Use

### Configure

Create your config file.

``` 
$ cp conf/Config.php.sample conf/Config.php
```

And edit it.

If you set `API_KEY` and `WID`, you can get your project list.

```
$ php get-project-list.php
```

And set `PID_MAP` and `TAG_MAP`.

## How to Run

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

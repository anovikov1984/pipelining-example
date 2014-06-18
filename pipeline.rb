require 'net/http/pipeline'

Net::HTTP.start 'pubsub.pubnub.com' do |http|
  req1 = Net::HTTP::Get.new '/publish/demo/demo/0/my_channel/0/"ONE"'
  req2 = Net::HTTP::Get.new '/publish/demo/demo/0/my_channel/0/"TWO"'
  req3 = Net::HTTP::Get.new '/publish/demo/demo/0/my_channel/0/"THREE"'

  http.pipeline [req1, req2, req3] do |res|
    puts res.code
    puts res.body[0..60].inspect
    puts
  end

  sleep 1

  http.pipeline [req1, req2, req3] do |res|
    puts res.code
    puts res.body[0..60].inspect
    puts
  end
end
